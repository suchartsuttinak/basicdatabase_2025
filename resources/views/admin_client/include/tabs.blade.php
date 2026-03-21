<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<ul class="nav nav-tabs mb-4" role="tablist">
    {{-- TAB 1: เพิ่มข้อมูลผู้รับบริการ --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('client.edit') ? 'active' : '' }}"
           href="{{ route('client.edit', $client->id) }}" role="tab" aria-controls="client">
            <i class="bi bi-person-plus-fill me-1"></i> เพิ่มข้อมูลผู้รับบริการ
        </a>
    </li>

    {{-- TAB 2: บันทึกบิดาและมารดา --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('family.add','family.edit') ? 'active' : '' }}"
           href="{{ route('family.add', $client->id) }}" role="tab" aria-controls="family">
            <i class="bi bi-people-fill me-1"></i> บันทึกบิดาและมารดา
        </a>
    </li>

    {{-- TAB 3: บันทึกสมาชิกครอบครัว --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('member.create','member.show','member.edit') ? 'active' : '' }}"
           href="{{ route('member.create', $client->id) }}" role="tab" aria-controls="member">
            <i class="bi bi-house-heart-fill me-1"></i> บันทึกสมาชิกครอบครัว
        </a>
    </li>

    {{-- TAB 4: สอบข้อเท็จจริงเบื้องต้น --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('factfinding.add','factfinding.edit') ? 'active' : '' }}"
           href="{{ route('factfinding.add', $client->id) }}" role="tab" aria-controls="factfinding">
            <i class="bi bi-search-heart me-1"></i> สอบข้อเท็จจริงเบื้องต้น
        </a>
    </li>
</ul>