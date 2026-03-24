<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-6 text-center">
        
        <!-- Donation -->
        <div class="p-8 bg-gray-50 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-3xl font-bold text-primary mb-6">ร่วมสนับสนุนเรา</h2>
            <p class="text-gray-600 mb-8">
                คุณสามารถช่วยสนับสนุนระบบนี้ได้ผ่านการบริจาค เพื่อให้เราพัฒนาต่อไป
            </p>
            <div class="bg-white p-6 rounded-lg shadow text-left mb-6">
                <h3 class="text-xl font-semibold text-primary mb-4">ข้อมูลบัญชีสำหรับบริจาค</h3>
                <ul class="space-y-2 text-gray-700">
                    <li><strong>ธนาคาร:</strong> กสิกรไทย</li>
                    <li><strong>ชื่อบัญชี:</strong> นายสมชาย ใจดี</li>
                    <li><strong>เลขบัญชี:</strong> 123-4-56789-0</li>
                </ul>
            </div>
            <a href="#" class="px-8 py-3 bg-primary text-white font-semibold rounded-lg shadow hover:bg-primary-dark block text-center">
                บริจาคตอนนี้
            </a>
        </div>

        <!-- Report Issue -->
        <div class="p-8 bg-gray-50 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-3xl font-bold text-primary mb-6">แจ้งเรื่องช่วยเหลือ</h2>
            <p class="text-gray-600 mb-8">
                หากมีปัญหาความเดือดร้อน สามารถแจ้งเราได้
            </p>
            <!-- Report Issue -->
        
        <div class="p-8 bg-gray-50 rounded-lg shadow hover:shadow-lg transition">
            <form action="{{ route('issues.store') }}" method="POST" class="space-y-4 text-left">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2">ชื่อ-สกุลผู้แจ้ง</label>
                    <input type="text" name="fullname" class="w-full border rounded-lg px-4 py-2" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">เบอร์โทรศัพท์</label>
                    <input type="text" name="phone" class="w-full border rounded-lg px-4 py-2" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">เรื่องที่แจ้ง</label>
                    <textarea name="subject" rows="4" class="w-full border rounded-lg px-4 py-2" required></textarea>
                </div>
                <button type="submit" class="px-8 py-3 bg-secondary text-white font-semibold rounded-lg shadow hover:bg-gray-700">
                    แจ้งปัญหา
                </button>
            </form>
        </div>
                </div>

            </div>
        </section>