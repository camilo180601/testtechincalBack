<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        // all methods protected by auth:api via routes middleware
    }

    // GET /api/orders?page=1&per_page=10
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $query = Order::query();

        // Optionally filter by client_name / delivery_date for duplicate check
        if ($request->has('client_name')) {
            $query->where('client_name', $request->query('client_name'));
        }
        if ($request->has('delivery_date')) {
            $query->where('delivery_date', $request->query('delivery_date'));
        }

        // For this project, list only user's orders? PDF didn't force multi-tenant; we'll list all, but
        // apply role restrictions on write operations.
        $orders = $query->orderByDesc('id')->paginate($perPage);

        // meta
        $meta = [
            'current_page' => $orders->currentPage(),
            'per_page' => $orders->perPage(),
            'total' => $orders->total(),
            'last_page' => $orders->lastPage()
        ];

        return response()->json(['data' => $orders->items(), 'meta' => $meta]);
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (! $order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }
        return response()->json(['data' => $order]);
    }

    public function store(OrderRequest $request)
    {
        $user = auth('api')->user();

        // role check
        if (!in_array($user->role, ['operator', 'admin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $data = $request->validated();
        $data['user_id'] = $user->id;

        // uniqueness check (client_name + delivery_date)
        $exists = Order::where('client_name', $data['client_name'])
            ->where('delivery_date', $data['delivery_date'])
            ->exists();

        if ($exists) {
            return response()->json(['errors' => ['client_name' => ['Ya existe una orden con este cliente y fecha']]], 422);
        }

        $order = Order::create($data);
        return response()->json(['data' => $order], 201);
    }

    public function update(OrderRequest $request, $id)
    {
        $user = auth('api')->user();

        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        if (!in_array($user->role, ['operator', 'admin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $data = $request->validated();

        $duplicate = Order::where('client_name', $data['client_name'])
            ->where('delivery_date', $data['delivery_date'])
            ->where('id', '!=', $order->id)
            ->exists();

        if ($duplicate) {
            return response()->json(['errors' => ['client_name' => ['Duplicado de client_name + delivery_date']]], 422);
        }

        $order->update($data);
        return response()->json(['data' => $order]);
    }

    public function destroy($id)
    {
        $user = auth('api')->user();
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        if (!in_array($user->role, ['operator', 'admin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $order->delete();
        return response()->json(['message' => 'Orden eliminada']);
    }
}
