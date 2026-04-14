     <div class="co-header">
            <div class="co-header-title">
                <span class="co-header-icon">
                    <i class="bi bi-people-fill"></i>
                </span>
                <div class="co-header-text">
                    <h6>การติดตามเด็กที่พักอาศัยภายนอก</h6>
                    <p>รูปแบบใหม่ใช้มาตรฐานเดียวกันทั้ง เพิ่ม/แก้ไข</p>
                </div>
            </div>

            <div class="co-header-actions">
                <button type="button"
                        class="btn btn-primary co-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#createCaseOutsideModal">
                    <i class="bi bi-plus-circle"></i>
                    <span>เพิ่มข้อมูล</span>
                </button>

                <a href="{{ route('case_outside.filter', $client->id) }}"
                class="btn btn-outline-primary co-btn">
                    <i class="bi bi-funnel"></i>
                    <span>ค้นหา / Filter</span>
                </a>

                <a href="{{ route('case_outside.report', $client->id) }}"
                target="_blank"
                class="btn btn-success co-btn">
                    <i class="bi bi-printer"></i>
                    <span>รายงานทั้งหมด</span>
                </a>
            </div>
        </div>
