# Football E-Commerce Platform - Sàn TMĐT Đặt Sân Bóng & Dịch Vụ

> Đồ án Thương Mại Điện Tử - Hệ thống cung cấp dịch vụ đặt sân bóng theo mô hình B2C, tích hợp thanh toán trực tuyến, quản lý đơn hàng và dịch vụ đi kèm.

### Live Demo: `mangewebfootball`

---

## 1. Tổng quan mô hình TMĐT

Dự án hoạt động như một **Sàn TMĐT dịch vụ (Service E-commerce)**:

*   **Bên bán (Platform):** Cung cấp dịch vụ cho thuê sân bóng + bán lẻ các dịch vụ đi kèm (nước uống, thuê áo, trọng tài...).
*   **Bên mua (User):** Đặt sân theo khung giờ, mua thêm dịch vụ, thanh toán online.
*   **Giao dịch:** Là giao dịch dịch vụ có yếu tố thời gian thực (đặt chỗ theo slot), tương tự mô hình booking trên Traveloka, Booking.com.
*   **Thanh toán:** Tích hợp cổng thanh toán điện tử MoMo (TMĐT) + COD (tiền mặt).

### 2. Quy trình TMĐT cốt lõi

`Xem sân -> Kiểm tra trống (AJAX Realtime) -> Chọn khung giờ -> Thêm dịch vụ vào giỏ -> Thanh toán MoMo/COD -> Quản lý trạng thái đơn hàng -> Xuất hóa đơn PDF -> Đánh giá`

Đây là luồng chuẩn của một website TMĐT.

### 3. Tính năng TMĐT đã hoàn thiện

#### A. Phía Khách hàng (B2C E-Commerce Features)
*   **Catalog & Search:** Xem danh sách sân, lọc theo giá, loại sân.
*   **Giỏ hàng dịch vụ (Cart):** Thêm/bớt dịch vụ đi kèm khi đặt sân.
*   **Đặt hàng & Booking:** Đặt sân theo ngày/giờ, hệ thống check trùng giờ real-time.
*   **Quản lý đơn hàng:** Xem lịch sử booking, lịch sử order dịch vụ, trạng thái `pending / success / failed`.
*   **Thanh toán TMĐT:** Tích hợp MoMo Sandbox, quản lý trạng thái thanh toán.
*   **Tài khoản & CRM:** Đăng ký, đăng nhập, reset mật khẩu qua email, gửi feedback, chatbot hỗ trợ.

#### B. Phía Quản trị (E-Commerce Admin - Quản lý sàn)
*   **Quản lý sản phẩm/dịch vụ:** CRUD sân bóng, dịch vụ, tồn kho dịch vụ (inventory).
*   **Quản lý đơn hàng TMĐT:** Duyệt booking, quản lý order dịch vụ, quản lý thanh toán.
*   **Quản lý khách hàng & Phân quyền:** Role-based: Guest / User / Admin / Boss (Super Admin quản lý user & role).
*   **Báo cáo TMĐT:** Thống kê doanh thu, dashboard, xuất hóa đơn PDF, Excel export report (roadmap).

### 4. Chức năng nâng cao của sàn

*   Kiểm tra trùng lịch AJAX real-time
*   Quản lý tồn kho dịch vụ
*   Quản lý trạng thái thanh toán đa cổng
*   Phân quyền Role chi tiết
*   Thống kê doanh thu
*   QR Check-in khi đến sân (roadmap)
*   Hệ thống Coupon / Mã giảm giá (roadmap)

### 5. Công nghệ sử dụng

**Backend (Xử lý nghiệp vụ TMĐT):** Laravel 10, PHP 8.x, MySQL
**Frontend:** Blade, Bootstrap 5, JavaScript (AJAX)
**Cổng thanh toán:** MoMo Payment Gateway
**Thư viện khác:** DomPDF (xuất hóa đơn), Chatbot

### Cấu trúc CSDL TMĐT chính
`users, roles, fields (sản phẩm chính), bookings (đơn đặt sân), services (sản phẩm phụ), orders, order_items, booking_payments, payments, feedback`

### 6. Cài đặt

```bash
git clone https://github.com/xinanhdung333/mangewebfootball.git
cd mangewebfootball
composer install
cp .env.example .env
php artisan key:generate
# Cấu hình DB_DATABASE, MOMO config trong .env
php artisan migrate --seed
php artisan serve