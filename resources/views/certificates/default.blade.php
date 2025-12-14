{{-- resources/views/certificates/default.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .title { font-size: 24px; font-weight: bold; margin: 20px 0; }
        .name { font-size: 20px; margin: 30px 0; }
    </style>
</head>
<body>
    <div class="title">SERTIFIKAT KELULUSAN</div>
    <div class="name">{{ $student->name }}</div>
    <div>Kursus: {{ $course->name }}</div>
    <div>Nilai: {{ $enrollment->grade }}/100</div>
    <div>Tanggal: {{ $enrollment->completed_at->format('d F Y') }}</div>
</body>
</html>
