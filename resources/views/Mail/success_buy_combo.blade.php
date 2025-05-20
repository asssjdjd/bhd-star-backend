<!DOCTYPE html>
<html>
<head>
    <title>Mua combo thành công - Bhd-star</title>
</head>
<body>
    <h1>Xin chào {{ Auth::user()->name }}, chúc mừng bạn đã mua combo đồ ăn thành công với các thông tin: </h1>
    <ul style="list-style-type: none;">
        <li><p>Tên rạp: {{ $details['theater_name'] }}</p></li>
        <li><p>Địa chỉ rạp: {{ $details['theater_address'] }}</p></li>
        @foreach($details['combos'] as $combo)
            <li><p>Combo: {{ $combo['name'] }} - Số lượng: {{ $combo['quantity'] }}</p></li>
        @endforeach
        <li><p>Tổng tiền: {{ number_format($details['totalCost']) }} VND</p></li>
    </ul>
    <p>Vui lòng đưa email này cho nhân viên lễ tân để được nhận combo đồ ăn! Đây là email tự động vui lòng không trả lời lại!</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    <p>Trân trọng!</p>
    <p>BHD-star</p>
</body>
</html>
