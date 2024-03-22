# mautic-connector-API-for-wordpress-plugin
English
This is a plugin connecting WordPress to Mautic using API
1. mautic.scovietnam.com (your domain)
2. $mautic_api_username = 'mautic_user_login'; // Replace with your Mautic username
3. $mautic_api_password = 'mautic_password_login'; // Replace with your Mautic password
4. Change : 
// Add the newly registered user to the Mautic segment
add_user_to_mautic_segment($mautic_contact_id, '1'); // Replace '1' with your segment ID

----
Vietnamese:
Đây là plugin kết nối giữa Wordpres sang Mautic sử dụng API.

Bạn hãy sửa lại các thông số cho phù hợp với thực tế:

mautic.scovietnam.com (miền của bạn)
$mautic_api_username = 'mautic_user_login'; // Thay thế bằng tên người dùng Mautic của bạn
$mautic_api_password = 'mautic_password_login'; // Thay thế bằng mật khẩu Mautic của bạn
Thay đổi ID phân đoạn của bạn:
// Thêm người dùng mới đăng ký vào phân đoạn Mautic
add_user_to_mautic_segment($mautic_contact_id, '1'); // Thay '1' bằng ID phân đoạn của bạn