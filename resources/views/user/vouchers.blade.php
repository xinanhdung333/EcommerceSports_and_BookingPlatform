@extends('layouts.app')

@section('content')
@php
    $activeFilter = request('filter', 'all');
    $filters = [
        'all' => ['label' => 'Tất cả', 'icon' => 'bi-grid'],
        'ending' => ['label' => 'Sắp hết hạn', 'icon' => 'bi-clock'],
        'low_min' => ['label' => 'Dễ dùng', 'icon' => 'bi-lightning-charge'],
    ];
@endphp

<style>
    .voucher-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: clamp(12px, 2vw, 24px) 0 36px;
    }

    .voucher-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 20px;
        align-items: center;
        padding: clamp(20px, 3vw, 34px);
        border-radius: 18px;
        color: #0f172a;
        background: linear-gradient(115deg, #fff 55%, #fff7ed 100%);
        border: 1px solid #edf0f5;
        box-shadow: 0 8px 24px rgba(15,23,42,.07);
        position: relative;
        overflow: hidden;
    }

    .voucher-hero::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 5px;
        background: linear-gradient(180deg, #ff6b00, #ffd814);
    }

    .voucher-hero-copy {
        position: relative;
        z-index: 1;
    }

    .voucher-hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 8px;
        color: #c2410c;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .voucher-hero h1 {
        margin: 0 0 9px;
        font-size: clamp(1.55rem, 4vw, 2rem);
        line-height: 1.15;
        font-weight: 800;
    }

    .voucher-hero p {
        margin: 0;
        max-width: 620px;
        color: #64748b;
        font-size: clamp(.9rem, 2vw, 1rem);
        line-height: 1.55;
    }

    .voucher-hero-icon {
        width: clamp(78px, 12vw, 128px);
        aspect-ratio: 1;
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 22px;
        display: grid;
        place-items: center;
        background: linear-gradient(145deg, #ff6b00, #ff9900);
        color: #fff;
        font-size: clamp(2rem, 6vw, 3.4rem);
        box-shadow: 0 10px 22px rgba(255,107,0,.23);
        transform: rotate(3deg);
    }

    .voucher-toolbar {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) auto;
        gap: 12px;
        align-items: center;
        margin: 16px 0;
    }

    .voucher-search {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 46px;
        padding: 0 15px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 3px 10px rgba(15,23,42,.06);
        transition: border-color .15s, box-shadow .15s;
    }

    .voucher-search:focus-within {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245,158,11,.14);
    }

    .voucher-search input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        font-size: .92rem;
    }

    .voucher-filter {
        display: flex;
        gap: 7px;
        overflow-x: auto;
        padding-bottom: 2px;
    }

    .voucher-filter a {
        flex: 0 0 auto;
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0 13px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        color: #475569;
        background: #fff;
        text-decoration: none;
        font-size: .82rem;
        font-weight: 700;
        transition: .15s;
        white-space: nowrap;
    }

    .voucher-filter a:hover {
        border-color: #fbbf24;
        color: #c2410c;
        transform: translateY(-1px);
    }

    .voucher-filter a.active {
        color: #111827;
        border-color: #ffd814;
        background: #ffd814;
        box-shadow: 0 4px 10px rgba(255,216,20,.2);
    }

    .voucher-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 16px;
    }

    .voucher-card {
        position: relative;
        display: grid;
        grid-template-columns: 92px minmax(0, 1fr);
        min-height: 148px;
        border: 1px solid #e8edf3;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 12px rgba(15,23,42,.07);
        transition: transform .18s, box-shadow .18s, border-color .18s;
    }

    .voucher-card:hover {
        transform: translateY(-3px);
        border-color: #fed7aa;
        box-shadow: 0 10px 22px rgba(15,23,42,.11);
    }

    .voucher-card::before,
    .voucher-card::after {
        content: "";
        position: absolute;
        left: 84px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #f8fafc;
        z-index: 2;
    }

    .voucher-card::before { top: -8px; }
    .voucher-card::after { bottom: -8px; }

    .voucher-left {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        color: #0f1111;
        background: linear-gradient(160deg, #fff7ed, #ffedd5);
        text-align: center;
        padding: 12px 8px;
    }

    .voucher-left i {
        font-size: 1.65rem;
        color: #ea580c;
    }

    .voucher-left span {
        color: #9a3412;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .voucher-body {
        min-width: 0;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .voucher-value {
        color: #e11d48;
        font-size: clamp(1.18rem, 2vw, 1.45rem);
        font-weight: 900;
        line-height: 1.1;
    }

    .voucher-code-row {
        display: flex;
        gap: 8px;
        align-items: center;
        min-width: 0;
        margin-top: auto;
    }

    .voucher-code {
        flex: 1;
        min-width: 0;
        border: 1px dashed #cbd5e1;
        border-radius: 9px;
        padding: 8px 10px;
        color: #0f172a;
        background: #f8fafc;
        font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        font-weight: 800;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .voucher-copy {
        flex: 0 0 auto;
        border: 1px solid #facc15;
        border-radius: 9px;
        padding: 8px 11px;
        color: #111827;
        background: #ffd814;
        font-weight: 800;
        transition: transform .15s, background .15s;
    }

    .voucher-copy:hover {
        background: #ffca05;
        transform: translateY(-1px);
    }

    .voucher-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 14px;
        color: #64748b;
        font-size: .78rem;
    }

    .voucher-empty {
        border: 1px dashed #cbd5e1;
        border-radius: 14px;
        padding: 44px 18px;
        text-align: center;
        background: #fff;
        color: #667085;
        box-shadow: 0 4px 12px rgba(15,23,42,.04);
    }

    @media (max-width: 767px) {
        .voucher-page {
            padding-top: 8px;
        }

        .voucher-hero,
        .voucher-toolbar {
            grid-template-columns: 1fr;
        }

        .voucher-hero {
            padding: 15px;
            border-radius: 14px;
        }

        .voucher-hero-icon {
            display: none;
        }

        .voucher-toolbar {
            gap: 10px;
            margin-top: 12px;
            margin-bottom: 12px;
        }

        .voucher-filter {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .voucher-filter a {
            justify-content: center;
            padding: 0 8px;
            font-size: .75rem;
        }

        .voucher-grid {
            gap: 10px;
        }

        .voucher-card {
            min-height: 118px;
        }
    }

    @media (max-width: 430px) {
        .voucher-grid {
            grid-template-columns: 1fr;
        }

        .voucher-card {
            grid-template-columns: 76px minmax(0, 1fr);
            min-height: 108px;
        }

        .voucher-card::before,
        .voucher-card::after {
            left: 68px;
        }

        .voucher-body {
            padding: 10px 11px;
            gap: 6px;
        }

        .voucher-left {
            padding: 10px 6px;
        }

        .voucher-left i {
            font-size: 1.35rem;
        }

        .voucher-left span {
            font-size: .68rem;
        }

        .voucher-code-row {
            gap: 6px;
        }

        .voucher-copy {
            padding: 7px 9px;
            font-size: .85rem;
        }

        .voucher-code {
            padding: 7px 8px;
            font-size: .9rem;
        }
    }
</style>

<section class="voucher-page">
    <div class="voucher-hero">
        <div class="voucher-hero-copy">
            <div class="voucher-hero-kicker"><i class="bi bi-stars"></i> Ưu đãi dành riêng cho bạn</div>
            <h1>Kho voucher SportsHub</h1>
            <p>Lưu mã giảm giá trước khi thanh toán đơn hàng. Chọn mã phù hợp với giá trị đơn để tiết kiệm nhiều hơn.</p>
        </div>
        <div class="voucher-hero-icon" aria-hidden="true">
            <i class="bi bi-ticket-perforated"></i>
        </div>
    </div>

    <form class="voucher-toolbar" method="GET" action="{{ route('user.vouchers') }}">
        <label class="voucher-search">
            <i class="bi bi-search text-muted"></i>
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Tìm mã voucher">
            <input type="hidden" name="filter" value="{{ $activeFilter }}">
        </label>

        <div class="voucher-filter" aria-label="Lọc voucher">
            @foreach($filters as $key => $filter)
                <a class="{{ $activeFilter === $key ? 'active' : '' }}"
                   href="{{ route('user.vouchers', array_filter(['filter' => $key === 'all' ? null : $key, 'q' => request('q')])) }}">
                    <i class="bi {{ $filter['icon'] }}"></i>{{ $filter['label'] }}
                </a>
            @endforeach
        </div>
    </form>

    @if($vouchers->count())
        <div class="voucher-grid">
            @foreach($vouchers as $voucher)
                @php
                    $type = $voucher->discount_type ?? 'fixed';
                    $expiresAt = $voucher->expires_at ? \Carbon\Carbon::parse($voucher->expires_at) : null;
                    $daysLeft = $expiresAt ? now()->diffInDays($expiresAt, false) : null;
                @endphp
                <article class="voucher-card">
                    <div class="voucher-left">
                        <i class="bi {{ $type === 'free_shipping' ? 'bi-truck' : 'bi-bag-heart' }}"></i>
                        <span>{{ $type === 'free_shipping' ? 'Freeship' : 'Voucher' }}</span>
                    </div>
                    <div class="voucher-body">
                        <div class="voucher-value">
                            @if($type === 'percentage')
                                -{{ rtrim(rtrim(number_format($voucher->discount_amount, 2, ',', '.'), '0'), ',') }}%
                            @elseif($type === 'free_shipping')
                                Freeship
                            @else
                                -{{ number_format($voucher->discount_amount, 0, ',', '.') }}đ
                            @endif
                        </div>
                        <div>Áp dụng cho đơn từ {{ number_format($voucher->min_order_amount, 0, ',', '.') }}đ</div>
                        @if($type === 'percentage' && $voucher->max_discount_amount)
                            <div class="small text-muted">Giảm tối đa {{ number_format($voucher->max_discount_amount, 0, ',', '.') }}đ</div>
                        @endif

                        <div class="voucher-code-row">
                            <div class="voucher-code" title="{{ $voucher->code }}">{{ $voucher->code }}</div>
                            <button type="button" class="voucher-copy" data-code="{{ $voucher->code }}">
                                <i class="bi bi-copy"></i> Sao chép
                            </button>
                        </div>

                        <div class="voucher-meta">
                            <span><i class="bi bi-clock me-1"></i>{{ $expiresAt ? 'HSD ' . $expiresAt->format('d/m/Y H:i') : 'Không giới hạn thời gian' }}</span>
                            @if($daysLeft !== null && $daysLeft <= 7)
                                <span class="text-danger fw-semibold">Sắp hết hạn</span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $vouchers->links() }}
        </div>
    @else
        <div class="voucher-empty">
            <i class="bi bi-ticket-perforated fs-1 d-block mb-2"></i>
            Hiện chưa có voucher phù hợp.
        </div>
    @endif
</section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.voucher-copy').forEach((button) => {
    button.addEventListener('click', async () => {
        const code = button.dataset.code || '';
        const oldHtml = button.innerHTML;

        try {
            await navigator.clipboard.writeText(code);
        } catch (error) {
            const temp = document.createElement('input');
            temp.value = code;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            temp.remove();
        }

        button.innerHTML = '<i class="bi bi-check2"></i> Đã chép';
        setTimeout(() => {
            button.innerHTML = oldHtml;
        }, 1400);
    });
});
</script>
@endpush
