<?php

namespace Webkul\GraphQLAPI\Http\Controllers\Shop\API;

use Illuminate\Support\Facades\Event;
use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Repositories\ProductReviewRepository;
use Webkul\Product\Repositories\ProductReviewAttachmentRepository;
use Webkul\Shop\Http\Controllers\API\ReviewController as ReviewControllerBase;

class ReviewController extends ReviewControllerBase
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected ProductReviewRepository $productReviewRepository,
        protected ProductReviewAttachmentRepository $productReviewAttachmentRepository
    ) {}

    /**
     * Pending review status.
     */

    const STATUS_PENDING = 'pending';

    /**
     * Approved review status.
     */
    const STATUS_APPROVED = 'approved';

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $id): JsonResource
    {
        $this->validate(request(), [
            'title'         => 'required',
            'comment'       => 'required',
            'rating'        => 'required|numeric|min:1|max:5',
            'attachments'   => 'array',
            'attachments.*' => 'file|mimetypes:image/*,video/*',
        ]);

        $data = array_merge(request()->only([
            'title',
            'comment',
            'rating',
        ]), [
            'attachments' => request()->file('attachments') ?? [],
            'status'      => self::STATUS_PENDING,
            'product_id'  => $id,
        ]);

        $data['name'] = auth()->guard('customer')->user()?->name ?? request()->input('name');
        $data['customer_id'] = auth()->guard('customer')->id() ?? null;

        Event::dispatch('customer.review.create.before', $id);

        $review = $this->productReviewRepository->create($data);

        $this->productReviewAttachmentRepository->upload($data['attachments'], $review);

        Event::dispatch('customer.review.create.after', $review);

        return new JsonResource([
            'message' => trans('shop::app.products.view.reviews.success'),
        ]);
    }
}
