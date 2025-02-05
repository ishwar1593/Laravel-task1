<?php

namespace App\Jobs;

use App\Models\DraftProduct;
use App\Models\PublishedProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Exception;
use Throwable;

class PublishedProductJob implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $draftProductId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $draftProductId)
    {
        $this->draftProductId = $draftProductId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction(); // Start a DB transaction

        try {
            // Retrieve Draft Product
            $draftProduct = DraftProduct::find($this->draftProductId);
            if (!$draftProduct) {
                Log::error("Draft product not found for ID: {$this->draftProductId}");
                return;
            }

            // Generate a unique product_ws_code
            $productWsCode = 'PR0-' . now()->format('YmdHis') . '-' . Str::random(4);

            // Create published product
            $publishedProduct = PublishedProduct::create([
                'draft_product_id' => $draftProduct->id,
                'product_ws_code' => $productWsCode,
                'product_name' => $draftProduct->product_name,
                'manufacturer_name' => $draftProduct->manufacturer_name,
                'category_id' => $draftProduct->category_id,
                'sales_price' => $draftProduct->sales_price,
                'mrp' => $draftProduct->mrp,
                'molecule_string' => $draftProduct->molecule_string,
                'is_banned' => $draftProduct->is_banned,
                'is_discontinued' => $draftProduct->is_discontinued,
                'is_assured' => $draftProduct->is_assured,
                'is_refridgerated' => $draftProduct->is_refridgerated,
                'is_published' => true,
                'created_by' => $draftProduct->created_by,
                'updated_by' => $draftProduct->updated_by,
                'is_active' => $draftProduct->is_active,
                'deleted_by' => $draftProduct->deleted_by,
            ]);

            if (!$publishedProduct) {
                throw new Exception("Failed to create published product for draft product ID: {$draftProduct->id}");
            }

            // Update is_published in DraftProduct
            $draftProduct->is_published = true;
            $draftProduct->save();

            DB::commit(); // Commit the transaction

            Log::info("Published product (ID: {$publishedProduct->id}) created from draft product ID: {$draftProduct->id}");

        } catch (QueryException $qe) {
            DB::rollBack(); // Rollback in case of DB error
            Log::error("Database error: " . $qe->getMessage());
            $this->fail($qe); // Mark job as failed

        } catch (Throwable $e) {
            DB::rollBack(); // Rollback in case of general error
            Log::error("Unexpected error in PublishedProductJob: " . $e->getMessage());
            report($e); // Report exception to Laravel logs
            $this->fail($e); // Mark job as failed
        }
    }
}
