<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="javascript:;" class="brand-link">
            <img src="/assets/backend/img/logo1_fr.png" alt="" class="brand-image" />
            {{-- <span class="brand-text fw-light">Bintang Media</span> --}}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                @foreach (get_induk() as $gm)
                    @php
                        $level2 = get_parent()->where('id_parent', $gm->id);
                        $isActiveLevel1 = isGrandLevelActive($gm, $level2);
                    @endphp

                    <li
                        class="nav-item {{ $level2->isNotEmpty() ? 'has-treeview' : '' }} {{ $isActiveLevel1 ? 'menu-open' : '' }}">
                        <a href="{{ $level2->isEmpty() ? $gm->public_id : 'javascript:;' }}"
                            class="nav-link {{ $isActiveLevel1 ? 'active' : '' }}">
                            <i class="nav-icon {{ $gm->icon }}"></i>
                            <p>
                                {{ ucwords($gm->nama) }}
                                @if ($level2->isNotEmpty())
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                @endif
                            </p>
                        </a>

                        @if ($level2->isNotEmpty())
                            <ul class="nav nav-treeview">
                                @foreach ($level2 as $l2)
                                    @php
                                        $level3 = get_child()->where('id_parent_child', $l2->id);
                                        $isActiveLevel2 = isLevelActive($l2, $level3);
                                    @endphp

                                    <li
                                        class="nav-item {{ $level3->isNotEmpty() ? 'has-treeview' : '' }} {{ $isActiveLevel2 ? 'menu-open' : '' }}">
                                        <a href="{{ $level3->isEmpty() ? $l2->public_id : 'javascript:;' }}"
                                            class="nav-link {{ $isActiveLevel2 ? 'active' : '' }}">
                                            <i class="nav-icon {{ $l2->icon }}"></i>
                                            <p>
                                                {{ ucwords($l2->nama) }}
                                                @if ($level3->isNotEmpty())
                                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                                @endif
                                            </p>
                                        </a>

                                        @if ($level3->isNotEmpty())
                                            <ul class="nav nav-treeview">
                                                @foreach ($level3 as $l3)
                                                    <li class="nav-item"> {{-- Untuk Sub Menu Child --}}
                                                        <a href="{{ $l3->public_id }}"
                                                            class="nav-link {{ isMenuActive($l3->public_id) ? 'active' : '' }}">
                                                            <i class="nav-icon {{ $l3->icon }}"></i>
                                                            <p>{{ ucwords($l3->nama) }}</p>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
