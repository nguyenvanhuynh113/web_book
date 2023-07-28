<!DOCTYPE html>
<html>
<head>
    <title>Text to Speech</title>
</head>
<body>
<h1>Chuyển đổi văn bản thành giọng nói tiếng Việt</h1>
<textarea id="text" rows="4" cols="50" placeholder="Nhập đoạn văn bản..."></textarea>
<br>
<label for="rate">Tốc độ đọc (0.1 - 10):</label>
<input type="range" id="rate" value="1" step="0.1" min="0.1" max="10">
<br>
<label for="volume">Âm lượng (0 - 1):</label>
<input type="range" id="volume" value="1" step="0.1" min="0" max="1">
<br>
<label for="pitch">Pitch (0 - 2):</label>
<input type="range" id="pitch" value="1" step="0.1" min="0" max="2">
<br>
<button onclick="speakText()">Đọc văn bản</button>

<script>
    function speakText() {
        var text = document.getElementById('text').value;
        var rate = parseFloat(document.getElementById('rate').value);
        var volume = parseFloat(document.getElementById('volume').value);
        var pitch = parseFloat(document.getElementById('pitch').value);

        // Kiểm tra xem trình duyệt có hỗ trợ Web Speech API hay không
        if ('speechSynthesis' in window) {
            var msg = new SpeechSynthesisUtterance();
            var viVoice = null;

            // Tìm giọng đọc tiếng Việt trong danh sách giọng hỗ trợ
            var voices = window.speechSynthesis.getVoices();
            for (var i = 0; i < voices.length; i++) {
                if (voices[i].lang === 'vi-VN') {
                    viVoice = voices[i];
                    break;
                }
            }

            // Sử dụng giọng tiếng Việt mặc định nếu không tìm thấy giọng tiếng Việt cụ thể
            msg.voice = viVoice || speechSynthesis.getVoices()[0];
            msg.lang = 'vi-VN';
            msg.text = text;
            msg.rate = rate;
            msg.volume = volume;
            msg.pitch = pitch;

            window.speechSynthesis.speak(msg);
        } else {
            alert('Trình duyệt của bạn không hỗ trợ Web Speech API!');
        }
    }
</script>
</body>
</html>
