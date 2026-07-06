<?php

namespace App\Http\Controllers\Orders;

use App\Contracts\Services\OrderServiceInterface;
use App\DTOs\Orders\CreateOrderDto;
use App\DTOs\Orders\UpdateOrderDto;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Orders\OrderRequest;
use App\Http\Resources\Orders\OrderResource;
use Illuminate\Http\JsonResponse;

class OrderController extends ApiController
{
    public function __construct(
        private readonly OrderServiceInterface $orderService,
    ) {}

    public function index(): JsonResponse
    {
        $orders = OrderResource::collection($this->orderService->getAll());

        return $this->setBody(['orders' => $orders])->sendResponse();
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $dto = CreateOrderDto::fromRequest($request->validated());
        $order = $this->orderService->create($dto);

        return $this->setBody(['order' => new OrderResource($order)])
            ->setMessage('Order created successfully.')
            ->setStatusCode(201)
            ->sendResponse();
    }

    public function show(string $id): JsonResponse
    {
        $order = $this->orderService->findOrFail((int) $id);

        return $this->setBody(['order' => new OrderResource($order)])->sendResponse();
    }

    public function update(OrderRequest $request, string $id): JsonResponse
    {
        $dto = UpdateOrderDto::fromRequest($request->validated());
        $order = $this->orderService->update((int) $id, $dto);

        return $this->setBody(['order' => new OrderResource($order)])
            ->setMessage('Order updated successfully.')
            ->sendResponse();
    }

    public function destroy(string $id): JsonResponse
    {
        $this->orderService->destroy((int) $id);

        return $this->setBody(null)
            ->setMessage('Order deleted successfully.')
            ->setStatusCode(204)
            ->sendResponse();
    }
}
