<div class="card border-0 shadow-sm psychiatric-client-card mb-3">
    <style>
        .psy-client-pro-card {
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
        }

        .psy-client-pro-body {
            padding: 1rem 1.1rem;
        }

        .psy-client-pro-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .psy-client-pro-item {
            grid-column: span 6;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.9rem 1rem;
            border: 1px solid #edf2f7;
            border-radius: 14px;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            transition: all 0.2s ease;
        }

        .psy-client-pro-item:hover {
            border-color: #bfdbfe;
            background: #f8fbff;
        }

        .psy-client-pro-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            background: #eff6ff;
            color: #2563eb;
        }

        .psy-client-pro-icon.success {
            background: #ecfdf5;
            color: #16a34a;
        }

        .psy-client-pro-content {
            min-width: 0;
        }

        .psy-client-pro-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #64748b;
            line-height: 1.2;
        }

        .psy-client-pro-value {
            font-size: 0.96rem;
            font-weight: 600;
            color: #0f172a;
            line-height: 1.4;
            word-break: break-word;
        }

        /* responsive */
        @media (max-width: 767.98px) {
            .psy-client-pro-item {
                grid-column: span 12;
            }
        }

        @media (max-width: 575.98px) {
            .psy-client-pro-body {
                padding: 0.9rem;
            }

            .psy-client-pro-item {
                padding: 0.85rem;
            }

            .psy-client-pro-value {
                font-size: 0.92rem;
            }
        }
    </style>

    <div class="psy-client-pro-card">
        <div class="psy-client-pro-body">
            <div class="psy-client-pro-grid">

                <!-- ชื่อ -->
                <div class="psy-client-pro-item">
                    <div class="psy-client-pro-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="psy-client-pro-content">
                        <div class="psy-client-pro-label">ชื่อ-สกุล</div>
                        <div class="psy-client-pro-value">
                            {{ $client->fullname ?? '-' }}
                        </div>
                    </div>
                </div>

                <!-- อายุ -->
                <div class="psy-client-pro-item">
                    <div class="psy-client-pro-icon success">
                        <i class="bi bi-calendar-heart"></i>
                    </div>
                    <div class="psy-client-pro-content">
                        <div class="psy-client-pro-label">อายุ</div>
                        <div class="psy-client-pro-value">
                            {{ $client->age ?? '-' }} ปี
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>