<?php

namespace App\Http\Controllers\Orders;

use App\DTOs\Orders\CreateOrderDto;
use App\DTOs\Orders\UpdateOrderDto;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Orders\OrderRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends ApiController
{
    public function __construct(private readonly OrderService $orderService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = OrderResource::collection($this->orderService->getAll());

        return $this->setBody(['orders' => $orders])->sendResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request): JsonResponse
    {
        $dto = CreateOrderDto::fromRequest($request->validated());
        $order = $this->orderService->create($dto);

        return $this->setBody(['order' => new OrderResource($order)])
            ->setMessage('Order created successfully.')
            ->setStatusCode(201)
            ->sendResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $order = $this->orderService->findOrFail((int) $id);
        } catch (ModelNotFoundException) {
            throw new NotFoundHttpException('Order not found.', null);
        }

        return $this->setBody(['order' => new OrderResource($order)])->sendResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id): JsonResponse
    {
        try {
            $order = $this->orderService->findOrFail((int) $id);
        } catch (ModelNotFoundException) {
            throw new NotFoundHttpException('Order not found.', null);
        }

        $dto = UpdateOrderDto::fromRequest($request->validated());
        $updatedOrder = $this->orderService->update($order->id, $dto);

        return $this->setBody(['order' => new OrderResource($updatedOrder)])
            ->setMessage('Order updated successfully.')
            ->sendResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->orderService->destroy((int) $id);
        } catch (ModelNotFoundException) {
            throw new NotFoundHttpException('Order not found.', null);
        }

        return $this->setBody(null)
            ->setMessage('Order deleted successfully.')
            ->setStatusCode(204)
            ->sendResponse();
    }
}
