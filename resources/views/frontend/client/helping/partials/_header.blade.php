        <div class="hp-main-header">
            <div class="hp-header-title">
                <span class="hp-header-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </span>
                <div class="hp-header-text">
                    <h6>รายการให้ความช่วยเหลือผู้รับ</h6>
                    <p>ออกแบบใหม่ให้ทันสมัย อ่านง่าย และใช้งานได้ดีทุกขนาดหน้าจอ</p>
                </div>
            </div>

            <a href="{{ route('help_sessions.create', $client->id) }}" class="btn btn-primary hp-btn">
                <i class="bi bi-plus-circle"></i>
                <span>เพิ่มการช่วยเหลือใหม่</span>
            </a>
        </div>