@extends('layouts.app')
@section('content')

{{-- ========== UPGRADED MY SERVICES ========== --}}
<style>
/* --- Desktop Premium --- */
@media (min-width: 768px) {
  .sh-page-header{background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:20px 24px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 1px 3px rgba(0,0,0,.04);}
  .sh-page-title{display:flex;align-items:center;gap:14px;}
  .sh-icon-box{width:44px;height:44px;border-radius:12px;background:#fffbeb;color:#d97706;display:grid;place-items:center;font-size:20px;border:1px solid #fde68a;}
  .sh-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;}
  .sh-stat{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:14px 16px;transition:.2s;cursor:pointer;}
  .sh-stat:hover{border-color:#facc15;box-shadow:0 4px 12px rgba(0,0,0,.06);transform:translateY(-1px);}
  .sh-filter-bar{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:14px 16px;}
  .sh-tab{padding:8px 14px;border-radius:10px;font-size:13px;font-weight:600;color:#64748b;cursor:pointer;border:1px solid transparent;transition:.15s;white-space:nowrap;}
  .sh-tab.active{background:#0f172a;color:#fff;border-color:#0f172a;}
  .sh-tab:hover{background:#f1f5f9;}
  .sh-search-wrap{position:relative;}
  .sh-search-wrap i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;}
  .sh-search-wrap input{padding-left:36px;height:40px;border-radius:12px;background:#f8fafc;border:1px solid #e2e8f0;font-size:13px;}
  .sh-search-wrap input:focus{background:#fff;border-color:#facc15;box-shadow:0 0 0 3px rgba(250,204,21,.15);}
}
/* --- Mobile Shopee Style (giữ logic cũ, làm đẹp hơn) --- */
@media (max-width: 767px) {
  .desktop-only{display:none!important;}
  .mobile-order-header{display:flex;align-items:center;gap:12px;padding:12px 16px;background:#fff;border-bottom:1px solid #f1f5f9;position:sticky;top:0;z-index:100;}
  .mobile-order-header h5{font-size:16px;font-weight:800;margin:0;color:#0f172a;}
  .mobile-order-tabs{display:flex;background:#fff;border-bottom:1px solid #f1f5f9;overflow-x:auto;scrollbar-width:none;position:sticky;top:48px;z-index:99;padding:0 8px;}
  .mobile-order-tabs::-webkit-scrollbar{display:none;}
  .mobile-order-tab{flex-shrink:0;padding:12px 14px;font-size:13px;font-weight:600;color:#64748b;border-bottom:2px solid transparent;margin-bottom:-1px;white-space:nowrap;}
  .mobile-order-tab.active{color:#ee4d2d;border-bottom-color:#ee4d2d;font-weight:800;}
  .mobile-search-bar{padding:10px 12px;background:#f5f5f5;}
  .mobile-search-bar input{width:100%;border:none;border-radius:999px;padding:10px 16px;font-size:14px;background:#fff;box-shadow:0 1px 4px rgba(0,0,0,.06);outline:none;}
  .mobile-stats-row{display:flex;gap:8px;padding:10px 12px;}
  .mobile-stat-pill{flex:1;background:#fff;border-radius:12px;padding:10px 6px;text-align:center;box-shadow:0 1px 4px rgba(0,0,0,.06);font-size:11px;color:#64748b;}
  .mobile-stat-pill .stat-num{font-size:16px;font-weight:800;color:#ee4d2d;display:block;}
  #service-table-area .row.g-4{flex-direction:column!important;gap:10px!important;padding:8px 12px!important;}
  #service-table-area .row.g-4>[class*="col-"]{width:100%!important;padding:0!important;}
  #service-table-area .card{border-radius:14px!important;border:none!important;box-shadow:0 2px 10px rgba(0,0,0,.06)!important;}
  #service-table-area .row.g-0{flex-direction:row!important;flex-wrap:nowrap!important;}
  #service-table-area .col-sm-4{width:76px!important;min-width:76px!important;flex:none!important;}
  #service-table-area .col-sm-4 .order-image-stack{width:60px!important;height:60px!important;margin:12px auto!important;}
  #service-table-area .col-sm-8{flex:1!important;}
  #service-table-area .card-body{padding:12px 12px 10px 4px!important;}
  #service-table-area .row.g-3.mb-4{display:none!important;}
}
@media (min-width:768px){.mobile-only{display:none!important;}}
</style>

{{-- MOBILE --}}
<div class="mobile-only">
  <div class="mobile-order-header">
    <a href="{{ url()->previous() }}" class="text-dark" style="font-size:18px"><i class="bi bi-arrow-left"></i></a>
    <h5><i class="bi bi-bag-check me-1"></i> Đơn hàng đã mua</h5>
  </div>
  <div class="mobile-order-tabs">
    <div class="mobile-order-tab active" data-status="">Tất cả</div>
    <div class="mobile-order-tab" data-status="pending">Chờ xác nhận</div>
    <div class="mobile-order-tab" data-status="confirmed">Đã xác nhận</div>
    <div class="mobile-order-tab" data-status="completed">Hoàn thành</div>
    <div class="mobile-order-tab" data-status="cancelled">Đã hủy</div>
  </div>
  <div class="mobile-search-bar">
    <input type="text" id="mobile-search" placeholder="🔍 Tìm kiếm đơn hàng..." value="{{ $keyword ?? '' }}">
  </div>
  <div class="mobile-stats-row desktop-only-mobile">
    <div class="mobile-stat-pill"><span class="stat-num">44</span>Tổng</div>
    <div class="mobile-stat-pill"><span class="stat-num">2</span>Chờ xử lý</div>
    <div class="mobile-stat-pill"><span class="stat-num">3</span>Đã xác nhận</div>
  </div>
</div>

{{-- DESKTOP --}}
<div class="container-fluid py-4" style="max-width:1480px">
  <div class="desktop-only">
    <div class="sh-page-header mb-4">
      <div class="sh-page-title">
        <div class="sh-icon-box"><i class="bi bi-bag-check"></i></div>
        <div>
          <h1 style="font-size:20px;font-weight:800;margin:0;color:#0f172a">Dịch vụ & Đơn hàng đã đặt</h1>
          <p style="font-size:12px;color:#64748b;margin:2px 0 0">Quản lý, theo dõi trạng thái giao hàng và lịch đặt sân</p>
        </div>
      </div>
      <div class="d-flex gap-2">
        <button onclick="loadServices()" class="btn btn-light btn-sm" style="border-radius:10px;border:1px solid #e2e8f0"><i class="bi bi-arrow-clockwise me-1"></i> Làm mới</button>
        <a href="{{ route('user.services') }}" class="btn btn-dark btn-sm" style="border-radius:10px;background:#0f172a"><i class="bi bi-plus-lg me-1" style="color:#facc15"></i> Đặt dịch vụ mới</a>
      </div>
    </div>

    <div class="sh-stats mb-4">
      <div class="sh-stat" onclick="document.getElementById('status-filter').value='';loadServices()"><div class="d-flex justify-content-between mb-2"><span style="font-size:12px;color:#64748b">Tổng dịch vụ</span><i class="bi bi-list-check"></i></div><div class="d-flex justify-content-between align-items-baseline"><span style="font-size:22px;font-weight:800">44</span><span style="font-size:11px;background:#ecfdf5;color:#059669;padding:2px 8px;border-radius:999px">+3 tuần này</span></div></div>
      <div class="sh-stat" onclick="document.getElementById('status-filter').value='pending';loadServices()" style="border-color:#fde68a"><div class="d-flex justify-content-between mb-2"><span style="font-size:12px;color:#b45309">Chờ xử lý</span><i class="bi bi-clock-history" style="color:#d97706"></i></div><div class="d-flex justify-content-between align-items-baseline"><span style="font-size:22px;font-weight:800;color:#d97706">2</span><span style="font-size:11px;background:#fffbeb;color:#b45309;padding:2px 8px;border-radius:999px">Cần thanh toán</span></div></div>
      <div class="sh-stat" onclick="document.getElementById('status-filter').value='confirmed';loadServices()"><div class="d-flex justify-content-between mb-2"><span style="font-size:12px;color:#047857">Đã xác nhận</span><i class="bi bi-check-circle" style="color:#059669"></i></div><div class="d-flex justify-content-between align-items-baseline"><span style="font-size:22px;font-weight:800;color:#059669">3</span><span style="font-size:11px;background:#ecfdf5;color:#047857;padding:2px 8px;border-radius:999px">Đang chuẩn bị</span></div></div>
      <div class="sh-stat"><div class="d-flex justify-content-between mb-2"><span style="font-size:12px;color:#1d4ed8">Đã hoàn thành</span><i class="bi bi-truck" style="color:#2563eb"></i></div><div class="d-flex justify-content-between align-items-baseline"><span style="font-size:22px;font-weight:800;color:#2563eb">39</span><span style="font-size:11px;background:#f1f5f9;color:#64748b;padding:2px 8px;border-radius:999px">Lịch sử</span></div></div>
    </div>

    <div class="sh-filter-bar mb-4">
      <div class="d-flex align-items-center gap-2 mb-3" style="overflow-x:auto">
        <div class="sh-tab active" data-filter="">Tất cả (44)</div>
        <div class="sh-tab" data-filter="pending">Chờ xử lý <span class="badge bg-warning text-dark ms-1">2</span></div>
        <div class="sh-tab" data-filter="confirmed">Đã xác nhận <span class="badge bg-success ms-1">3</span></div>
        <div class="sh-tab" data-filter="completed">Hoàn thành</div>
        <div class="sh-tab" data-filter="cancelled">Đã hủy</div>
      </div>
      <div class="row g-2 align-items-center">
        <div class="col-md-5"><div class="sh-search-wrap"><i class="bi bi-search"></i><input type="text" id="search-input" class="form-control" placeholder="Tìm theo mã đơn #141, tên sản phẩm..." value="{{ $keyword ?? request('keyword','') }}"></div></div>
        <div class="col-md-3"><select id="status-filter" class="form-select" style="height:40px;border-radius:12px;font-size:13px"><option value="">Tất cả trạng thái</option><option value="pending" {{ request('status',$filterStatus??'')==='pending'?'selected':'' }}>Chờ xử lý</option><option value="confirmed" {{ request('status',$filterStatus??'')==='confirmed'?'selected':'' }}>Đã thanh toán</option><option value="cancelled" {{ request('status',$filterStatus??'')==='cancelled'?'selected':'' }}>Đã hủy</option></select></div>
        <div class="col-md-4 text-end"><small class="text-muted">Hiển thị 1-10 trong 44 dịch vụ</small></div>
      </div>
    </div>
  </div>

  {{-- KHU VỰC TABLE GIỮ NGUYÊN LOGIC CŨ --}}
  <div id="service-table-area" class="py-2">
    @isset($myServices)
      @include('user.service-table')
    @endisset
  </div>
</div>

<script>
// Tabs desktop + mobile
document.querySelectorAll('.sh-tab').forEach(t=>{
  t.addEventListener('click',function(){
    document.querySelectorAll('.sh-tab').forEach(x=>x.classList.remove('active'));
    this.classList.add('active');
    document.getElementById('status-filter').value=this.dataset.filter;
    loadServices();
  });
});
document.querySelectorAll('.mobile-order-tab').forEach(tab=>{
  tab.addEventListener('click',function(){
    document.querySelectorAll('.mobile-order-tab').forEach(t=>t.classList.remove('active'));
    this.classList.add('active');
    document.getElementById('status-filter').value=this.dataset.status;
    loadServices();
  });
});
const mobileSearch=document.getElementById('mobile-search');
if(mobileSearch){mobileSearch.addEventListener('keyup',()=>{document.getElementById('search-input').value=mobileSearch.value;loadServices();});}

function loadServices(url=null){
  const keyword=document.getElementById('search-input').value;
  const status=document.getElementById('status-filter').value;
  if(!url){url=`{{ route('user.services.search') }}?keyword=${encodeURIComponent(keyword)}&status=${encodeURIComponent(status)}&partial=1`;}
  fetch(url,{headers:{'X-Requested-With':'XMLHttpRequest'}})
  .then(res=>res.text())
  .then(data=>{
    if(data.includes('<html')||data.includes('<!DOCTYPE html')){
      const doc=new DOMParser().parseFromString(data,'text/html');
      const partial=doc.querySelector('#service-table-area');
      if(partial){document.getElementById('service-table-area').innerHTML=partial.innerHTML;return;}
    }
    document.getElementById('service-table-area').innerHTML=data;
  });
}
document.addEventListener('click',function(e){
  const link=e.target.closest('#service-table-area .service-pagination a');
  if(link){e.preventDefault();const url=new URL(link.href);url.searchParams.set('keyword',document.getElementById('search-input').value);url.searchParams.set('status',document.getElementById('status-filter').value);url.searchParams.set('partial','1');loadServices(url.toString());}
});
document.getElementById('search-input').addEventListener('keyup',()=>loadServices());
document.getElementById('status-filter').addEventListener('change',()=>loadServices());

setInterval(()=>{document.querySelectorAll('.order-card[data-order-id]').forEach(card=>{const badge=card.querySelector('.shipping-status-badge');if(!badge)return;fetch(`{{ url('/user/order') }}/${card.dataset.orderId}/shipping-status`,{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}}).then(r=>r.ok?r.json():null).then(d=>{if(!d)return;const label=d.ghn_status_label||d.shipment_status_label;if(label){badge.innerHTML=`<i class="bi bi-truck me-1"></i>${d.ghn_code?'GHN: ':''}${label}`;}}).catch(()=>{});});},10000);
</script>
@endsection