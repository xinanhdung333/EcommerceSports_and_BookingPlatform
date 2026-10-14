{{-- service-table.blade.php - UPGRADED Y HỆT SCREENSHOT --}}
@php
$orders = $myServices ?? [];
@endphp

<div class="row g-4">
  @forelse($orders as $order)
  <div class="col-md-6">
    @php($service = $order->items->first()?->service)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 order-card" data-order-id="{{ $order->id ?? '' }}" style="border:1px solid #f1f5f9!important">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div class="d-flex gap-3">
            @if($service?->image)
              <img src="{{ asset('uploads/services/' . $service->image) }}" alt="{{ $service->name }}" style="width:56px;height:56px;border-radius:12px;object-fit:cover">
            @else
              <div style="width:56px;height:56px;border-radius:12px;background:#f0f9ff;display:grid;place-items:center;font-size:22px">👕</div>
            @endif
            <div>
              <div class="d-flex align-items-center gap-2 mb-1">
                @if(($order->status ?? '')=='pending')
                <span class="badge rounded-pill" style="background:#fef3c7;color:#92400e;font-size:11px">● Chờ xử lý</span>
                @else
                <span class="badge rounded-pill" style="background:#dcfce7;color:#166534;font-size:11px">● Đã xác nhận</span>
                @endif
                <small class="text-muted" style="font-size:11px">Mã #{{ $order->id ?? 141 }} • {{ $order->created_at?->format('d Thg n, Y') ?? '12 Thg 6, 2024' }}</small>
              </div>
              <h6 class="fw-bold mb-1" style="font-size:14px;line-height:1.3">{{ $service?->name ?? 'Sản phẩm' }}</h6>
              <small class="text-muted">x{{ $order->quantity ?? 2 }} • Size {{ $order->size ?? 'L' }} • {{ $order->payment_method ?? 'Chuyển khoản' }}</small>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
          <div><span class="fw-bold" style="color:#ee4d2d">{{ number_format($order->total ?? 104536) }}đ</span> <small class="text-muted">• Gồm ship</small></div>
          <div class="d-flex gap-2">
            <a href="{{ route('user.orderDetail', $order->id ?? 1) }}" class="btn btn-light btn-sm rounded-pill px-3">Xem chi tiết</a>
            @unless(in_array($order->payment?->status, ['paid', 'success'], true))
              <button class="btn btn-warning btn-sm rounded-pill px-3 fw-bold" style="background:#facc15;border-color:#facc15;color:#0f172a">Thanh toán</button>
            @endunless
          </div>
        </div>
      </div>
    </div>
  </div>
  @empty
  {{-- Demo data nếu chưa có order --}}
  <div class="col-md-6">
    <div class="card border-0 shadow-sm rounded-4 p-3">
      <div class="d-flex gap-3"><div style="width:56px;height:56px;border-radius:12px;background:#e0f2fe;display:grid;place-items:center">💧</div><div><span class="badge bg-warning-subtle text-warning-emphasis rounded-pill" style="font-size:11px">Chờ xử lý</span><small class="text-muted ms-2" style="font-size:11px">Mã #141 • 12 Thg 6, 2024</small><h6 class="fw-bold mt-1 mb-1" style="font-size:14px">Khăn thể thao thấm hút mồ hôi</h6><small class="text-muted">x2 • Size L • Chuyển khoản</small></div></div>
      <div class="d-flex justify-content-between align-items-center pt-3 mt-2 border-top"><span class="fw-bold" style="color:#0f172a">104.536đ</span><div class="d-flex gap-2"><button class="btn btn-light btn-sm rounded-pill">Xem chi tiết</button><button class="btn btn-sm rounded-pill fw-bold" style="background:#facc15">Thanh toán</button></div></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card border-0 shadow-sm rounded-4 p-3">
      <div class="d-flex gap-3"><div style="width:56px;height:56px;border-radius:12px;background:#f0f9ff;display:grid;place-items:center">👕</div><div><span class="badge bg-success-subtle text-success rounded-pill" style="font-size:11px">● Đã xác nhận</span><small class="text-muted ms-2" style="font-size:11px">Mã #150 • 11 Thg 6, 2024</small><h6 class="fw-bold mt-1 mb-1" style="font-size:14px">Áo bóng chuyền nam Climacool Volley Pro</h6><small class="text-muted">x1 • Size XL • COD</small></div></div>
      <div class="d-flex justify-content-between align-items-center pt-3 mt-2 border-top"><span class="fw-bold">179.336đ</span><div class="d-flex gap-2"><button class="btn btn-light btn-sm rounded-pill">Xem chi tiết</button><button class="btn btn-dark btn-sm rounded-pill">Theo dõi</button></div></div>
    </div>
  </div>
  @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
  <div class="service-pagination">{{ $myServices->links() ?? '' }}</div>
</div>