

  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      margin: 0;
      background: #f2f2f2;
    }

    /* Header */
    .header {
      width: 100%;
      background: #00c896;
      padding: 20px 40px;
      font-size: 22px;
      font-weight: bold;
      text-align: center;
    }

    /* Konten Full Width */
    .content {
      width: 100%;
      padding: 40px 80px 120px 80px;
      display: flex;
      flex-direction: column;
      align-items: center; /* RATA TENGAH */
    }

    h1 {
      text-align: center;
      margin-bottom: 40px;
      font-size: 50px;
    }

    h3 {
      margin-bottom: 12px;
      font-size: 20px;
      text-align: left;
    }

    p {
      font-size: 16px;
      line-height: 1.8;
      text-align: justify;
      margin-bottom: 25px;
      max-width: 1000px;
    }

    /* Kotak video */
    .video-box {
      width: 500px;
      max-width: 100%;
      aspect-ratio: 16/9;
      background: #d9d9d9;
      border-radius: 8px;
      margin: 0 auto 20px auto;
    }

    .video-title {
      font-size: 14px;
      color: #666;
      margin-bottom: 30px;
      text-align: center;
    }

    hr {
      border: none;
      height: 2px;
      background: #ddd;
      margin: 40px auto;
      max-width: 1000px;
      width: 100%;
    }

    /* Tombol */
    .btn-box {
      width: 300px;
      background: #e0e0e0;
      text-align: center;
      padding: 14px;
      margin: 0 auto 15px auto;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
    }

    /* Navigasi bawah */
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: #ffffff;
      border-top: 1px solid #ddd;
      padding: 15px 80px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav-btn {
      background: #00c896;
      border: none;
      padding: 12px 40px;
      border-radius: 30px;
      font-weight: bold;
      cursor: pointer;
      font-size: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .content {
        padding: 20px 15px 120px 15px;
      }

      .bottom-nav {
        padding: 12px 20px;
      }

      .video-box {
        width: 100%;
      }
    }
  </style>
</head>

<body>

  

  <!-- Konten -->
  <div class="content">

    <h1>Naratif Teknis</h1>

    
    <p>
      Naratif teknis adalah teks atau penjelasan berbentuk narasi (cerita) yang digunakan untuk
      menjelaskan proses, prosedur, atau teknologi secara sistematis. Naratif teknis adalah teks atau penjelasan berbentuk narasi (cerita) yang digunakan untuk
      menjelaskan proses, prosedur, atau teknologi secara sistematis.Naratif teknis adalah teks atau penjelasan berbentuk narasi (cerita) yang digunakan untuk
      menjelaskan proses, prosedur, atau teknologi secara sistematis.Naratif teknis adalah teks atau penjelasan berbentuk narasi (cerita) yang digunakan untuk
      menjelaskan proses, prosedur, atau teknologi secara sistematis.
    </p>

    <div class="video-box"></div>
    <div class="video-title">Video pengenalan Youtube</div>

    <p>
      Naratif teknis membantu pembaca memahami langkah kerja secara runtut, jelas, dan terstruktur. Naratif teknis adalah teks atau penjelasan berbentuk narasi (cerita) yang digunakan untuk
      menjelaskan proses, prosedur, atau teknologi secara sistematis.Naratif teknis adalah teks atau penjelasan berbentuk narasi (cerita) yang digunakan untuk
      menjelaskan proses, prosedur, atau teknologi secara sistematis.
    </p>

    <div class="video-box"></div>
    <div class="video-title">Video pengenalan Youtube</div>

    <p>
      Teks ini banyak digunakan dalam pendidikan dan dunia industri untuk menjelaskan prosedur kerja.
    </p>

    <hr>

    <div class="btn-box">Quiz</div>
    <div class="btn-box">Esai</div>

  </div>

  <!-- Navigasi Bawah -->
  <div class="bottom-nav">
    <button class="nav-btn">Back</button>
    <button class="nav-btn">Next</button>
  </div>

