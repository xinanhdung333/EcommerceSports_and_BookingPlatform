# Brief cho Claude: Viết Chương 3 và Chương 4 báo cáo đồ án SportsHub

> **Định hướng cốt lõi:** Đây là đồ án **thương mại điện tử bán đồ thể thao**. Website cho phép khách hàng tìm và mua sản phẩm, thanh toán, giao nhận và theo dõi đơn. Đặt sân bóng là một phân hệ bổ sung trong cùng ứng dụng, không phải trọng tâm báo cáo.
>
> Hãy khảo sát repository trước khi viết. Dùng `BAO_CAO_TOM_TAT_DU_AN.txt` như tài liệu bối cảnh ban đầu, nhưng xác minh nội dung quan trọng với mã nguồn, test và môi trường hiện tại. Không xem bất kỳ chức năng đề xuất nào là đã triển khai nếu chưa có bằng chứng.

## 1. Vai trò, đầu việc và cấu trúc

Bạn là trợ lý viết báo cáo đồ án phần mềm bằng tiếng Việt. Soạn nội dung chi tiết, có tính học thuật, cho:

### CHƯƠNG 3: XÂY DỰNG VÀ TRIỂN KHAI HỆ THỐNG

- 3.1. Xây dựng giao diện (Frontend)
- 3.2. Lập trình backend (PHP + MySQL)
- 3.3. Các chức năng chính đã hoàn thiện
- 3.4. Một số hình ảnh demo hệ thống

### CHƯƠNG 4: KIỂM THỬ VÀ ĐÁNH GIÁ

- 4.1. Kế hoạch kiểm thử
- 4.2. Các trường hợp kiểm thử (Test case)
- 4.3. Kết quả kiểm thử
- 4.4. Đánh giá và hướng phát triển

Trình bày hệ thống như một cửa hàng trực tuyến bán sản phẩm thể thao (SportsHub). Phân hệ đặt sân và các tiện ích khác chỉ trình bày sau nghiệp vụ thương mại điện tử, với vai trò tính năng bổ sung. Không viết báo cáo như một ứng dụng booking có bán kèm đồ.

## 2. Tổng quan dự án đã biết

### 2.1. Mục đích và nghiệp vụ chính

SportsHub là ứng dụng web thương mại điện tử hướng tới bán sản phẩm/đồ thể thao. Luồng trọng tâm:

**Duyệt/tìm sản phẩm → xem chi tiết → thêm vào giỏ hoặc mua ngay → chọn sản phẩm cần thanh toán → nhập/chọn địa chỉ giao hàng → chọn vận chuyển và voucher → thanh toán → theo dõi đơn hàng/giao nhận.**

Các tính năng cửa hàng thể hiện trong tài liệu và mã nguồn gồm:

- Danh mục, danh sách và chi tiết sản phẩm; tìm kiếm, lọc, sắp xếp.
- Thông tin sản phẩm như tên, mô tả, giá, ảnh, số lượng tồn, danh mục và dữ liệu đánh giá.
- Giá khuyến mãi/giảm giá trong những luồng có cấu hình.
- Giỏ hàng: thêm, cập nhật số lượng, xóa, mua ngay, checkout một phần hoặc checkout giỏ hàng.
- Địa chỉ giao hàng, phương thức giao hàng, phí ship, ghi chú đơn.
- Voucher/khuyến mãi có điều kiện; cần xác minh loại voucher và cách áp dụng trước khi mô tả.
- Đơn hàng, chi tiết đơn, thanh toán, hóa đơn và theo dõi giao hàng.
- Giao diện quản trị danh mục/sản phẩm, tồn kho, đơn hàng, khách hàng, voucher và cấu hình liên quan.

Ngoài cửa hàng còn có phân hệ đặt sân bóng, dịch vụ đi kèm booking, quản lý sân, chat/chatbot, feedback và một số tiện ích khác. Các phân hệ này không được làm lu mờ trọng tâm bán hàng trong Chương 3–4.

### 2.2. Lưu ý tên gọi sản phẩm trong source code

Mã nguồn kế thừa tên kỹ thuật `Service`/`services` cho dữ liệu hàng hóa được bán. Model `Service` chứa các trường sản phẩm như `name`, `description`, `price`, `quantity`, `image`, `category_id`, `status` và rating; dữ liệu này có thể được gắn vào cart/order cũng như booking.

- Trong nội dung nghiệp vụ thương mại điện tử, gọi dữ liệu này là **sản phẩm** hoặc **hàng hóa thể thao** cho dễ hiểu.
- Khi cần chỉ đường tới source, ghi rõ “sản phẩm (model/bảng `Service`/`services` trong mã nguồn)”.
- Không nói hệ thống quản lý size, màu sắc, SKU, biến thể hoặc thuộc tính kho nếu chưa tìm được schema/logic cụ thể.
- Phân biệt sản phẩm bán trong đơn hàng với sản phẩm/dịch vụ được chọn kèm booking.

## 3. Công nghệ và kiến trúc có căn cứ ban đầu

Đối chiếu repository trước khi đưa các thông tin sau vào bản thảo:

- **Backend:** PHP 8.2 trở lên, Laravel Framework 12 theo `composer.json`.
- **Mô hình:** Laravel MVC, controller, Eloquent ORM, middleware, validation, migrations và Blade.
- **Frontend:** Blade render phía máy chủ; Bootstrap 5/Bootstrap Icons được nạp từ CDN ở các layout; có CSS riêng. Vite build `resources/css/app.css` và `resources/js/app.js`; có Tailwind directives và dependencies như Axios/Alpine.js. Chỉ mô tả các thư viện thực sự được dùng ở màn hình đang đề cập.
- **Cơ sở dữ liệu:** Laravel migrations mô tả schema. Kiểm tra `config/database.php`, `.env.example`, `phpunit.xml` và cấu hình Docker để phân biệt SQLite mặc định/test với MySQL trong môi trường dự kiến. Không đọc hay đưa giá trị bí mật từ `.env` vào báo cáo.
- **Web/API:** ứng dụng chủ yếu là web Blade qua `routes/web.php`; có REST API phiên bản `/api/v1` dùng Sanctum cho một số luồng. API hiện có auth/catalog và booking; không mặc định coi đây là API thương mại điện tử đầy đủ, không khẳng định đã có API giỏ hàng/checkout nếu chưa thấy.
- **Frontend build:** Vite với Laravel Vite plugin; xác minh command thực tế từ `package.json`.
- **Xuất hóa đơn:** có dependency DomPDF; xác minh các route/controller/view xuất invoice.
- **Tích hợp:** MoMo sandbox, chuyển khoản/QR và webhook SePay có mã nguồn cho thanh toán; GHN có mã tích hợp nhưng cấu hình mặc định có thể demo/mô phỏng. Việc có code không đồng nghĩa đã kết nối dịch vụ production.
- **Triển khai:** chỉ nêu Docker, Nginx, MySQL, Redis, WebSocket hoặc môi trường production nếu cấu hình hiện có và phạm vi báo cáo yêu cầu; phân biệt cấu hình mẫu với hệ thống thực sự đang chạy.

## 4. Mô hình dữ liệu thương mại điện tử

Kiểm tra migrations/models để mô tả chính xác. Các entity dự kiến liên quan tới cửa hàng:

- `users`: khách hàng, tài khoản, vai trò.
- `categories`: danh mục hàng hóa.
- `services` / model `Service`: sản phẩm, mô tả, giá, ảnh, tồn kho, trạng thái, danh mục và rating.
- `cart`, `cart_items`: giỏ hàng và dòng sản phẩm trong giỏ.
- `orders`, `order_items`: đơn hàng và dòng hàng, bao gồm số lượng/giá tại thời điểm đặt nếu được lưu.
- `payments`: giao dịch/thông tin thanh toán gắn với đơn hàng.
- `user_addresses`: địa chỉ nhận hàng.
- `shipping_methods`, `order_shipments`, `shipping_statuses`, `order_shipping_status_histories`: lựa chọn và tiến trình vận chuyển.
- `vouchers`, `settings`: khuyến mãi/cấu hình cửa hàng.
- `invoices`: hóa đơn.

Các entity của booking (fields, bookings, booking_services, booking_payments), chat, feedback, chatbot và activity log là các phân hệ bổ trợ. Không gộp booking vào mô hình đơn hàng mua sản phẩm nếu code lưu ở các bảng riêng.

## 5. Quy trình mua hàng và phương thức thanh toán

### 5.1. Luồng mua hàng

Khảo sát cụ thể controller trước khi khẳng định thứ tự bước:

1. Người mua tìm sản phẩm qua trang danh sách/chi tiết.
2. Backend lấy sản phẩm, giá hiện hành, giảm giá và tồn kho; không tin giá do client gửi nếu luồng backend lấy lại giá từ database.
3. Sản phẩm được thêm vào giỏ của người dùng; số lượng bị giới hạn bởi tồn kho theo logic hiện có.
4. Người dùng mua ngay, chọn một phần giỏ hàng hoặc checkout toàn bộ.
5. Backend tạo order/order items, tính tổng tiền, phí giao hàng và mức giảm voucher theo luồng tương ứng.
6. Người mua chọn địa chỉ/phương thức giao nhận và phương thức thanh toán.
7. Payment callback/webhook hoặc luồng tiền mặt cập nhật trạng thái; tồn kho được trừ theo đúng thời điểm thực hiện trong code.
8. Người dùng xem danh sách/chi tiết đơn và tiến trình giao hàng.

Có thể có khác biệt giữa các controller/luồng checkout. Trình bày khác biệt đáng kể, không gộp thành một quy trình duy nhất nếu mã nguồn xử lý không đồng nhất.

### 5.2. Thanh toán và giao hàng

- **Tiền mặt:** xác minh cụ thể thời điểm order/payment chuyển trạng thái và thời điểm giảm tồn kho.
- **MoMo:** có mã tạo yêu cầu và chuyển khách sang endpoint `test-payment.momo.vn`, cùng return/IPN và xác minh chữ ký/số tiền trong một số luồng. Đây là sandbox/test trong source; không tuyên bố đã phát sinh giao dịch thật.
- **Chuyển khoản/QR và SePay:** có mã tạo/hiển thị hướng dẫn QR và webhook. Xác minh signature, amount, mã đơn, chiều giao dịch và cơ chế chống xử lý lặp trước khi mô tả. Không nói đã đối soát với ngân hàng thật nếu không có bằng chứng.
- **VNPay:** không đưa vào danh sách tính năng hoàn thành chỉ vì `vnpay` xuất hiện trong enum hoặc migration; cần có route, controller, cấu hình và luồng callback thực thi để khẳng định.
- **GHN:** mô tả có mã nguồn tích hợp/lấy dữ liệu/tạo hoặc theo dõi shipment. Nếu cấu hình mặc định là demo/mô phỏng thì ghi rõ; không tuyên bố đã vận hành GHN production.
- **Phí vận chuyển:** xác minh nguồn tính (khoảng cách/dịch vụ/giá cố định/miễn phí theo ngưỡng), fallback và config trước khi diễn giải.

## 6. Hướng khảo sát trước khi soạn báo cáo

Ưu tiên source đang chạy và kết quả thực nghiệm hơn mô tả trong tài liệu:

1. Bối cảnh: `BAO_CAO_TOM_TAT_DU_AN.txt`, `README.md`, `composer.json`, `package.json`, `vite.config.js`.
2. Cấu hình DB, test và môi trường: `config/database.php`, `.env.example`, `phpunit.xml`, Docker/Compose nếu có. Không in giá trị secret.
3. Routes: `routes/web.php`, `routes/api.php`, `routes/auth.php`, `bootstrap/app.php`; middleware xác thực và role.
4. Luồng storefront: `PagesController`, `CartController`, controller thanh toán/đơn hàng/vận chuyển, `UsesServiceQuery`, helpers/services liên quan giảm giá và tồn kho.
5. Model/migrations: `Service`, `Category`, `Cart`, `CartItem`, `Order`, `OrderItem`, `Payment`, `UserAddress`, voucher, shipping và liên quan.
6. Views/JS/CSS của sản phẩm, chi tiết sản phẩm, giỏ, checkout, đơn hàng, payment, tracking và admin/boss.
7. Tests: `tests/Feature`, `tests/Unit`, `tests/Browser`, cấu hình PHPUnit; chạy suite/build nếu môi trường sẵn sàng.
8. Luồng booking chỉ khảo sát đủ để mô tả nó như **phân hệ bổ sung**.

Với mỗi tính năng chính, lần theo **route → middleware → controller → model/database/service → view hoặc JSON response**. Khi code/tài liệu khác nhau, ưu tiên code có bằng chứng và ghi nhận điểm chưa thống nhất.

### Quy tắc độ tin cậy

- Gắn nhãn rõ **đã xác minh từ mã nguồn**, **có mô tả nhưng chưa xác minh**, **đã chạy kiểm thử**, **chưa chạy**, hoặc **đề xuất tương lai**.
- Không bịa phiên bản MySQL đang chạy, cấu hình triển khai, người dùng thực, doanh thu, giao dịch, tốc độ, khả năng chịu tải hoặc tỷ lệ test thành công.
- Không tuyên bố một giao dịch sandbox là giao dịch production.
- Không tuyên bố callback/webhook an toàn/idempotent chỉ vì có chữ ký; kiểm tra code cụ thể.
- Không gán kết quả PASS cho test case chỉ dựa vào test code hoặc kỳ vọng.
- Khi thiếu bằng chứng, dùng `[CẦN BỔ SUNG: ...]`, `Chưa chạy`, `BLOCKED` hoặc “chưa xác minh”.
- Không đưa password demo, token, API key, secret, QR thanh toán dùng được hoặc dữ liệu cá nhân vào báo cáo.
- Không biến kế hoạch refactor/ý tưởng tương lai thành chức năng hiện có.

## 7. Yêu cầu chi tiết Chương 3

### 3.1. Xây dựng giao diện (Frontend)

Đặt trọng tâm vào hành trình mua sắm:

- Trình bày Blade server-rendered, cấu trúc layout/partial/view và vai trò Bootstrap, CSS riêng, Vite/JavaScript dựa trên code.
- Mô tả các màn hình theo thứ tự người dùng: trang chủ SportsHub; danh sách sản phẩm/danh mục/tìm kiếm; chi tiết sản phẩm; giỏ hàng; checkout; chọn địa chỉ/voucher/vận chuyển/thanh toán; lịch sử/chi tiết đơn hàng; tracking; trang admin quản lý sản phẩm và đơn.
- Nêu thành phần hiển thị như ảnh, giá gốc/giá giảm, tồn kho, số lượng, tổng tiền, thông báo validation và trạng thái đơn nếu có căn cứ từ Blade/JS.
- Mô tả thao tác AJAX/JSON chỉ ở nơi thực sự dùng; phân biệt với form HTML và redirect.
- Giải thích giao diện admin/boss/shipper theo quyền truy cập thực tế. Đặt booking, chat/chatbot và feedback ở phần cuối như tiện ích/phân hệ phụ.
- Responsive/accessibility chỉ được đánh giá sau khi kiểm tra CSS và chạy giao diện ở kích thước phù hợp.

### 3.2. Lập trình backend (PHP + MySQL)

- Giải thích kiến trúc Laravel MVC và cách route/middleware/controller/model/view hỗ trợ storefront và khu vực quản trị.
- Nêu DB theo cấu hình dự án: migrations, Eloquent và môi trường MySQL/SQLite phù hợp; không gọi MySQL là DB đang chạy nếu chưa kiểm tra.
- Trình bày schema trung tâm: category–product (`Service`/`services`)–cart–order/order item–payment–address–shipment–voucher.
- Mô tả giá/giảm giá, kiểm tra tồn kho, cách tạo order, transaction và lúc giảm tồn; xác minh code trước khi mô tả như một bảo đảm toàn hệ thống.
- Mô tả quyền sở hữu đơn/giỏ/địa chỉ và role admin/boss/shipper dựa trên middleware/controller.
- Trình bày thanh toán và vận chuyển theo sandbox/demo/production status đã xác minh.
- Đề cập API `/api/v1` như API bổ trợ nếu code không có endpoint e-commerce cart/checkout; không mô tả ứng dụng là SPA hoặc API-first.
- Giải thích các phân hệ booking/chat/feedback ngắn gọn ở cuối như các chức năng mở rộng.

### 3.3. Các chức năng chính đã hoàn thiện

Ưu tiên theo thứ tự thương mại điện tử:

1. Tài khoản khách hàng và phân quyền.
2. Danh mục, tìm kiếm/lọc/sắp xếp và chi tiết sản phẩm thể thao.
3. Giá khuyến mãi/discount và quản lý tồn kho.
4. Giỏ hàng, cập nhật số lượng, xóa, mua ngay và checkout một phần/toàn bộ.
5. Địa chỉ giao hàng, voucher, tính phí vận chuyển và tạo đơn.
6. Thanh toán tiền mặt, MoMo sandbox, chuyển khoản QR/webhook SePay (nêu trạng thái xác minh).
7. Quản lý/xem đơn, hóa đơn và tiến trình vận chuyển.
8. Trang quản trị sản phẩm, danh mục, tồn kho, đơn, voucher và shipping; các tiện ích như feedback/chat.
9. Đặt sân bóng như phân hệ bổ sung, trình bày ngắn hơn các luồng mua hàng.

Với từng chức năng, nêu: mục đích/vai trò, thao tác người dùng, xử lý backend/dữ liệu, đầu ra/lỗi và bằng chứng source/test. Tránh chép đoạn code dài.

### 3.4. Một số hình ảnh demo hệ thống

Đề nghị chụp ảnh **thật từ ứng dụng đang chạy** và đánh số/caption:

- Hình 3.1: Trang chủ SportsHub.
- Hình 3.2: Danh sách sản phẩm, danh mục và bộ lọc/tìm kiếm.
- Hình 3.3: Chi tiết sản phẩm.
- Hình 3.4: Giỏ hàng với số lượng và tổng tiền.
- Hình 3.5: Checkout (địa chỉ, vận chuyển, voucher, thanh toán).
- Hình 3.6: Danh sách hoặc chi tiết đơn hàng.
- Hình 3.7: Trang quản trị sản phẩm/tồn kho.
- Hình 3.8: Trang quản trị đơn hàng.
- Hình 3.9: Tracking giao hàng; ghi rõ demo nếu là dữ liệu mô phỏng.
- Hình 3.10 (tùy chọn): Booking sân như phân hệ mở rộng.

Mỗi hình có caption “Hình 3.x. ...” và một câu giải thích. Nếu không thể chạy ứng dụng/chụp thật, ghi `[CHÈN ẢNH: ...]` và hướng dẫn trang cần mở; không tạo hình giả để mô tả là screenshot. Che thông tin cá nhân, credential, token, mã giao dịch và QR thanh toán thật.

## 8. Yêu cầu chi tiết Chương 4

### 4.1. Kế hoạch kiểm thử

Lập kế hoạch gắn với cửa hàng trực tuyến, tối thiểu gồm:

| Mã | Hạng mục | Mục tiêu | Loại/phương pháp | Môi trường/dữ liệu | Tiêu chí đạt |
|---|---|---|---|---|---|

Phạm vi ưu tiên:

- Tài khoản/role và quyền truy cập.
- Danh mục/catalog, tìm kiếm, lọc, sắp xếp, chi tiết sản phẩm.
- Giá giảm/voucher; tính tổng tiền và phí giao hàng.
- Thêm/sửa/xóa giỏ; mua ngay; checkout chọn lọc/toàn bộ.
- Tồn kho: đủ hàng, hết hàng, vượt số lượng, tạo đơn và thời điểm giảm tồn.
- Quyền xem/sửa đơn và địa chỉ thuộc về user.
- Thanh toán tiền mặt; MoMo sandbox; QR/webhook SePay bằng payload test nếu môi trường hỗ trợ.
- Giao hàng/tracking demo và quyền shipper/admin.
- API v1 hiện hữu và phân hệ booking ở mức phù hợp, không chiếm trọng tâm kiểm thử.
- Regression và hiển thị responsive ở các kích thước đã thực sự thử.

Nêu rõ các mục nằm ngoài phạm vi khi thiếu dịch vụ/credential: giao dịch MoMo thật, SePay production, GHN production, OAuth bên thứ ba, test tải hay pentest.

### 4.2. Các trường hợp kiểm thử (Test case)

Tạo bảng:

| TC ID | Chức năng | Tiền điều kiện | Dữ liệu và bước thực hiện | Kết quả mong đợi | Kết quả thực tế | Trạng thái |
|---|---|---|---|---|---|---|

Ít nhất hãy thiết kế các case:

- Xem danh sách sản phẩm; tìm kiếm/lọc/sắp xếp; mở chi tiết.
- Đăng nhập đúng/sai, email không tồn tại, dữ liệu bắt buộc bỏ trống.
- Thêm sản phẩm đủ tồn vào giỏ; từ chối sản phẩm hết hàng/vượt tồn.
- Tăng/giảm số lượng, xóa sản phẩm và kiểm tra lại tổng giỏ.
- Mua ngay; checkout một phần; checkout toàn bộ; giỏ rỗng hoặc item không thuộc user.
- Áp dụng voucher hợp lệ; từ chối voucher sai/hết hạn/không đủ đơn tối thiểu; xác minh không giảm quá số tiền phải trả.
- Tính phí ship/fallback/ngưỡng miễn phí dựa trên cấu hình thực tế.
- Tạo đơn và kiểm tra order items, đơn giá, số lượng, discount, địa chỉ và tổng thanh toán.
- Xác nhận thanh toán tiền mặt và giảm tồn đúng theo luồng hiện hành.
- Callback MoMo đúng/sai chữ ký, sai amount, thất bại; SePay HMAC/amount/mã đơn hợp lệ và không hợp lệ; không dùng giao dịch thật nếu chưa có phê duyệt.
- User chỉ xem đơn của chính mình; user thường không truy cập thao tác admin; role shipper chỉ thao tác phần được phép.
- Cập nhật/tracking trạng thái giao hàng với dữ liệu demo; phân biệt rõ với GHN production.
- API endpoint public/authenticated hiện có; booking test chỉ như case của phân hệ bổ sung.

Điền kết quả mong đợi dựa trên yêu cầu/source. Cột kết quả thực tế phải để `Chưa chạy`/`[CẦN CHẠY]` nếu chưa có bằng chứng. Dùng `BLOCKED` khi thử nghiệm bị chặn bởi môi trường, ghi rõ lý do.

### 4.3. Kết quả kiểm thử

- Tách test tự động, test thủ công và kiểm thử tích hợp dịch vụ ngoài.
- Chỉ ghi kết quả lệnh vừa thực thi hoặc log/biên bản có thể kiểm chứng. Cấu hình test và test source hiện diện không đồng nghĩa suite đã pass.
- Nếu chạy được, ghi ngày giờ, lệnh (`php artisan test`/`composer test`, `npm run build` nếu cần), môi trường, số lượng pass/fail/skip và lỗi liên quan. Không bịa số liệu.
- Nếu lỗi môi trường (DB, migration, dependency, credential, sandbox), ghi đúng blocker; không trình bày như tính năng đã đạt.
- Xem các test hiện hữu trong `tests/Feature`, bao gồm test API booking và login, nhưng phân loại theo phạm vi: bằng chứng cho API/booking không thay thế kiểm thử giỏ hàng, checkout, voucher, thanh toán đơn hàng hay giao nhận.
- Dùng bảng tổng hợp, chỉ điền số sau khi chạy:

| Nhóm kiểm thử | Đã chạy | Đạt | Không đạt | Bị chặn/chưa chạy | Ghi chú |
|---|---:|---:|---:|---:|---|

### 4.4. Đánh giá và hướng phát triển

Đánh giá trên bằng chứng, ưu tiên mục tiêu thương mại điện tử:

- **Kết quả đạt được:** catalog, giỏ hàng, checkout, payment, order, shipping và admin nào đã xác minh.
- **Ưu điểm:** ví dụ tách dữ liệu order/payment/address, kiểm tra tồn, voucher, role, tracking; chỉ nêu nếu code/test chứng minh.
- **Hạn chế:** thiếu test e-commerce tự động, môi trường MoMo/SePay/GHN phụ thuộc cấu hình, tracking demo, API chưa có cart/checkout, sai khác giữa các luồng hoặc điểm chưa kiểm chứng. Chỉ kết luận cụ thể khi đã xem code/output.
- **Hướng phát triển:** tăng test cho giỏ/checkout/discount/payment; chống xử lý webhook trùng; chuẩn hóa transaction và giảm tồn; hoàn thiện tích hợp vận chuyển production; xây API cart/order nếu cần frontend/mobile; theo dõi lỗi và hiệu năng sau khi đo; accessibility/responsive; cải thiện quản lý sản phẩm nếu có yêu cầu về SKU/size/màu.
- Có thể nêu booking sân, chatbot hoặc chat realtime là nhánh mở rộng; không kết luận chúng thay thế mục tiêu bán đồ thể thao.

## 9. Văn phong và đầu ra

- Viết tiếng Việt chuẩn, giọng văn báo cáo tốt nghiệp, thuật ngữ tiếng Anh giải thích ở lần xuất hiện đầu tiên.
- Giữ nguyên số mục 3.1–3.4 và 4.1–4.4; đánh số hình/bảng nhất quán.
- Trình bày theo nghiệp vụ cửa hàng, tránh văn phong marketing và đoạn lặp.
- Gắn nội dung quan trọng với bằng chứng (tên route/controller/view/model/test); không cần dán code dài.
- Thêm bảng test, lưu đồ mua hàng/thanh toán khi có ích.
- Kết thúc bản thảo với “Thông tin cần người thực hiện xác nhận/bổ sung”: tên trường/đề tài, DB thực tế, môi trường triển khai, ảnh chụp, kết quả test, credential/sandbox trạng thái, GHN demo hay production, phạm vi VNPay.
- Nếu có thể tạo file, xuất báo cáo thành file riêng `bao_cao_chuong_3_4.md`; không ghi đè brief này.

## 10. Tham chiếu nhanh

- Bối cảnh dự án: `BAO_CAO_TOM_TAT_DU_AN.txt`, `README.md`
- Công nghệ: `composer.json`, `package.json`, `vite.config.js`
- Routes: `routes/web.php`, `routes/api.php`, `routes/auth.php`
- Storefront views: `resources/views/user/services.blade.php`, `service-detail.blade.php`, `cart.blade.php`, `checkout.blade.php`, `checkout-multiple.blade.php`, `payment-method.blade.php`, `orders.blade.php`, `order-detail.blade.php`, `order-tracking.blade.php`
- Admin views: `resources/views/admin/manage-services.blade.php`, `manage-orders.blade.php`, cùng các view trong `resources/views/boss/`
- Nghiệp vụ: `app/Http/Controllers/PagesController.php`, `CartController.php`, `MomoController.php`, payment/webhook/shipping controllers; `app/Models/Service.php`, `Order.php`, `OrderItem.php`, `Cart.php`, `CartItem.php`, `Payment.php`, `Voucher.php`
- Test: `tests/Feature/`, `tests/Unit/`, `tests/Browser/`
- Booking: các controller/model/view trong `app/` và `resources/views/user/booking*.blade.php`; đây là phân hệ phụ trong báo cáo.
