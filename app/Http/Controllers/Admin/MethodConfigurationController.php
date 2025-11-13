<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\ShippingService;
use Illuminate\Http\Request;

class MethodConfigurationController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('name')->get();
        $shippingServices = ShippingService::orderBy('name')->get();

        return view('admin.config.index', compact('paymentMethods', 'shippingServices'));
    }

    public function storePaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'account_number' => 'nullable|string|max:100',
            'account_holder_name' => 'nullable|string|max:255',
        ]);

        PaymentMethod::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'is_active' => $request->boolean('is_active'),
            'account_number' => $validated['account_number'] ?? null,
            'account_holder_name' => $validated['account_holder_name'] ?? null,
        ]);

        return redirect()->route('admin.config.index')
                         ->with('success', 'Metode Pembayaran berhasil ditambahkan!');
    }

    public function editPaymentMethod(PaymentMethod $paymentMethod)
    {
        return view('admin.config.edit-payment-method', compact('paymentMethod'));
    }

    public function updatePaymentMethod(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name,' . $paymentMethod->id,
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $paymentMethod->id,
            'account_number' => 'nullable|string|max:100',
            'account_holder_name' => 'nullable|string|max:255',
        ]);

        $paymentMethod->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'is_active' => $request->has('is_active'),
            'account_number' => $request->account_number ?? null,
            'account_holder_name' => $request->account_holder_name ?? null,
        ]);

        return redirect()->route('admin.config.index')
                         ->with('success', 'Metode Pembayaran berhasil diperbarui!');
    }

    public function destroyPaymentMethod(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('admin.config.index')
                         ->with('success', 'Metode Pembayaran berhasil dihapus!');
    }

    public function storeShippingService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:shipping_services,name',
            'code' => 'required|string|max:50|unique:shipping_services,code',
            'estimation' => 'nullable|string|max:255',
        ]);

        ShippingService::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'estimation' => $validated['estimation'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.config.index')
                         ->with('success', 'Jasa Kirim berhasil ditambahkan!');
    }

    public function editShippingService(ShippingService $shippingService)
    {
        return view('admin.config.edit-shipping-service', compact('shippingService'));
    }

    public function updateShippingService(Request $request, ShippingService $shippingService)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:shipping_services,name,' . $shippingService->id,
            'code' => 'required|string|max:50|unique:shipping_services,code,' . $shippingService->id,
            'estimation' => 'nullable|string|max:255',
        ]);

        $shippingService->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'estimation' => $request->estimation,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.config.index')
                         ->with('success', 'Jasa Kirim berhasil diperbarui!');
    }

    public function destroyShippingService(ShippingService $shippingService)
    {
        $shippingService->delete();

        return redirect()->route('admin.config.index')
                         ->with('success', 'Jasa Kirim berhasil dihapus!');
    }
}
