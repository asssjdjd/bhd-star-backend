<!DOCTYPE html>
<html>
<head>
    <title>Mua vé thành công - Bhd-star</title>
</head>
<body>
    <h1>Xin chào {{ Auth::user()->name }}, chúc mừng bạn đã mua vé thành công với các thông tin: </h1>
    <ul style="list-style-type: none;">
        <li><p>Tên phim: {{ $details['film_name'] }}</p></li>
        <li><p>Tên rạp: {{ $details['theater_name'] }}</p></li>
        <li><p>Địa chỉ rạp: {{ $details['theater_address'] }}</p></li>
        <li><p>Ngày chiếu: {{ $details['start_time'] }}</p></li>
        @foreach($details['selectedSeats'] as $seat)
            <li><p>Ghế: {{ $seat }}</p></li>
        @endforeach
        @foreach($details['combos'] as $combo)
            <li><p>Combo: {{ $combo['name'] }} - Số lượng: {{ $combo['quantity'] }}</p></li>
        @endforeach
        <li><p>Tổng tiền: {{ $details['totalCost'] }} VND</p></li>
    </ul>
    <p>Vui lòng đưa email này cho nhân viên lễ tân để được nhận vé và đồ ăn! Đây là email tự động vui lòng không trả lời lại!</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    <p>Chúc bạn có một buổi xem phim vui vẻ!</p>
    <p>Trân trọng!</p>
    <p>BHD-star</p>
</body>
</html>