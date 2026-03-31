<div>
    <style>
        .addictive-header-pro {
            padding: 0.95rem 1.1rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fbff 0%, #eef5ff 60%, #ffffff 100%);
            border-radius: 14px 14px 0 0;
        }

        .addictive-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.9rem;
            flex-wrap: wrap;
        }

        .addictive-header-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
        }

        .addictive-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #2563eb;
            flex: 0 0 auto;
        }

        .addictive-header-icon i {
            font-size: 1rem;
        }

        .addictive-header-text {
            min-width: 0;
        }

        .addictive-header-title {
            margin: 0;
            font-size: 0.98rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.35;
        }

        .addictive-header-sub {
            margin-top: 0.15rem;
            font-size: 0.78rem;
            color: #64748b;
            line-height: 1.4;
        }

        .addictive-header-right {
            flex: 0 0 auto;
        }

        .addictive-header-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.85rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 10px;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.15);
            white-space: nowrap;
        }

        .addictive-header-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.2);
        }

        /* mobile */
        @media (max-width: 575.98px) {
            .addictive-header-pro {
                padding: 0.9rem;
            }

            .addictive-header-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .addictive-header-right {
                width: 100%;
            }

            .addictive-header-btn {
                width: 100%;
                justify-content: center;
            }

            .addictive-header-title {
                font-size: 0.92rem;
            }

            .addictive-header-sub {
                font-size: 0.75rem;
            }
        }
    </style>

    <div class="addictive-header-pro">
        <div class="addictive-header-inner">

            <!-- LEFT -->
            <div class="addictive-header-left">
                <div class="addictive-header-icon">
                    <i class="bi bi-clipboard2-pulse"></i>
                </div>

                <div class="addictive-header-text">
                    <h6 class="addictive-header-title">
                        ข้อมูลการตรวจสารเสพติด
                    </h6>
                    <div class="addictive-header-sub">
                        บันทึกผลการตรวจสารเสพติด และติดตามพฤติกรรมผู้รับบริการ
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="addictive-header-right">
                <button type="button"
                        class="btn btn-primary addictive-header-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#createAddictiveModal">
                    <i class="bi bi-plus-circle"></i>
                    <span>เพิ่มข้อมูล</span>
                </button>
            </div>

        </div>
    </div>
</div>