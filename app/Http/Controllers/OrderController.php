<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // ==========================================
    // Buyer Order Methods
    // ==========================================

    /**
     * Display successful orders
     */
    public function success()
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login first to view your orders');
        }
        $userId = Auth::id();
        $orders = Order::where('buyer_id', $userId)->get();
        $pendingCount = $orders->where('status', 'pending')->count();
        $shippedCount = $orders->where('status', 'shipped')->count();
        $cancelledCount = $orders->where('status', 'cancelled')->count();
        $completedCount = $orders->where('status', 'completed')->count();
        return view("buyerPage.orders.ordersAll", compact('orders','pendingCount','shippedCount','cancelledCount','completedCount'));
    }

    /**
     * Process order checkout
     */
    public function checkout(Request $request)
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login to view orders');
        }

        $selectedItems = json_decode($request->input('selected_items'), true);

        // Kelompokkan item berdasarkan shop_id
        $itemsByShop = collect($selectedItems)->groupBy(function ($item) {
            return Product::find($item['product_id'])->shop_id;
        });

        // Buat order untuk setiap toko
        foreach ($itemsByShop as $shopId => $items) {
            // Hitung total amount untuk toko ini
            $totalAmount = array_reduce($items->toArray(), function ($carry, $item) {
                return $carry + ($item['quantity'] * Product::find($item['product_id'])->price);
            }, 0);

            // Buat order baru untuk toko ini
            $order = Order::create([
                'invoice_number' => 'INV-' . time() . '-' . $shopId,
                'buyer_id' => Auth::id(),
                'shop_id' => $shopId,
                'status' => 'pending',
                'payment_method' => $request->input('payment_method'),
                'shipping_cost' => 10000, // Sesuaikan dengan biaya pengiriman
                'total_amount' => $totalAmount + 10000, // Total + shipping cost
            ]);

            // Buat order details untuk setiap produk
            foreach ($items as $item) {
                Order_detail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantityOrdered' => $item['quantity'],
                ]);
            }

            // Hapus item dari keranjang
            Cart_item::where('buyer_id', Auth::id())
                ->whereIn('product_id', $items->pluck('product_id'))
                ->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Orders berhasil dibuat');
    }

    public function buyerPending(){
        $user = Auth::user();

        $orders = Order::where('buyer_id', $user->id)
            ->where('status', 'pending')  // Add this line to filter pending orders
            ->with(['orderDetails.product', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('buyerPage.orders.pending', compact('orders'));
    }
    public function buyerShipped(){
        $user = Auth::user();

        $orders = Order::where('buyer_id', $user->id)
            ->where('status', 'shipped')  // Add this line to filter pending orders
            ->with(['orderDetails.product', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('buyerPage.orders.shipped', compact('orders'));
    }
    public function buyerCompleted(){
        $user = Auth::user();

        $orders = Order::where('buyer_id', $user->id)
            ->where('status', 'completed')  // Add this line to filter pending orders
            ->with(['orderDetails.product', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('buyerPage.orders.complete', compact('orders'));
    }
    public function buyerCancelled(){
        $user = Auth::user();

        $orders = Order::where('buyer_id', $user->id)
            ->where('status', 'cancelled')  // Add this line to filter pending orders
            ->with(['orderDetails.product', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('buyerPage.orders.cancelled', compact('orders'));
    }

    /**
     * Mark order as complete (buyer side)
     */
    public function complete(Order $order)
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login to acses this!');
        }

        $order->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Order marked as completed');
    }

    // ==========================================
    // Seller Order Methods
    // ==========================================

    /**
     * Display orders for seller's shop
     */
    public function sellerOrders()
    {
        $user = Auth::user();
        $shop = Shop::where('seller_id', $user->id)->first();

        if (!$shop) {
            return redirect()->route('home')->with('error', 'Shop not found');
        }

        $orders = Order::where('shop_id', $shop->id)
            ->where('status', 'pending')  // Add this line to filter pending orders
            ->with(['orderDetails.product', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sellerPage.orders.index', compact('orders'));
    }

    /**
     * Display shipped orders for seller
     */
    public function shippedOrders()
    {
        $user = Auth::user();
        $shop = Shop::where('seller_id', $user->id)->first();

        if (!$shop) {
            return redirect()->route('home')->with('error', 'Shop not found');
        }

        $orders = Order::where('shop_id', $shop->id)
            ->where('status', 'shipped')
            ->with(['orderDetails.product', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sellerPage.shipped.index', compact('orders'));
    }

    /**
     * Display cancelled orders for seller
     */
    public function cancelledOrders()
    {
        $user = Auth::user();
        $shop = Shop::where('seller_id', $user->id)->first();

        if (!$shop) {
            return redirect()->route('home')->with('error', 'Shop not found');
        }

        $orders = Order::where('shop_id', $shop->id)
            ->where('status', 'cancelled')
            ->with(['orderDetails.product', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sellerPage.cancelled.index', compact('orders'));
    }

    /**
     * Display completed orders for seller
     */
    public function completedOrders()
    {
        $user = Auth::user();
        $shop = Shop::where('seller_id', $user->id)->first();

        if (!$shop) {
            return redirect()->route('home')->with('error', 'Shop not found');
        }

        $orders = Order::where('shop_id', $shop->id)
            ->where('status', 'completed')
            ->with(['orderDetails.product', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sellerPage.complete.index', compact('orders'));
    }

    /**
     * Update order status (seller side)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:shipped,cancelled'
        ]);

        if ($request->status === 'shipped') {
            // Check if any product has insufficient stock
            foreach ($order->orderDetails as $detail) {
                if ($detail->quantityOrdered > $detail->product->stock) {
                    return redirect()->back()->with('error', 'Cannot ship order: Insufficient stock for some products');
                }
            }

            // Update stock for each product
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product;
                $product->stock -= $detail->quantityOrdered;
                $product->save();
            }
        }

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Order status has been updated successfully.');
    }
}
