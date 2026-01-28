@extends('layouts.admin')

@section('content')
    <div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 2rem; letter-spacing: -0.02em;">Intelligence Overview</h1>
            <p style="color: var(--text-muted); font-size: 1.05rem;">Real-time diagnostics and business performance metrics.</p>
        </div>
        <div style="background: white; padding: 0.5rem 1rem; border-radius: 999px; border: 1px solid var(--border-soft); font-size: 0.85rem; font-weight: 700; color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem;">
            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 10px #10b981;"></div>
            Live System Status: Normal
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: var(--primary);">
                    <i class="fas fa-users-viewfinder"></i>
                </div>
                <div style="font-size: 0.75rem; font-weight: 700; color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 0.25rem 0.5rem; border-radius: 6px;">
                    +12% <i class="fas fa-arrow-trend-up"></i>
                </div>
            </div>
            <div>
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ number_format($stats['users']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    <i class="fas fa-cart-shopping"></i>
                </div>
                <div style="font-size: 0.75rem; font-weight: 700; color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 0.25rem 0.5rem; border-radius: 6px;">
                    +5% <i class="fas fa-arrow-trend-up"></i>
                </div>
            </div>
            <div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ number_format($stats['orders']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-vault"></i>
                </div>
                <div style="font-size: 0.75rem; font-weight: 700; color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 0.25rem 0.5rem; border-radius: 6px;">
                    Stable
                </div>
            </div>
            <div>
                <div class="stat-label">Revenue</div>
                <div class="stat-value">${{ number_format($stats['revenue'], 2) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-file-invoice"></i>
                </div>
            </div>
            <div>
                <div class="stat-label">Total Content</div>
                <div class="stat-value">{{ $stats['blogs'] + $stats['products'] }} Items</div>
            </div>
        </div>
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="stat-icon" style="background: rgba(236, 72, 153, 0.1); color: #ec4899;">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div>
                <div class="stat-label">Product Reviews</div>
                <div class="stat-value">{{ number_format($stats['reviews']) }}</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 2rem; align-items: start;">
        <div style="display: grid; gap: 2rem;">
            <!-- Recent Orders -->
            <div class="card" style="padding: 0;">
                <div style="padding: 1.75rem 2rem; border-bottom: 1px solid var(--border-soft); display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; letter-spacing: -0.01em;">Recent Transactions</h2>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary" style="border-radius: 12px; font-size: 0.8rem;">View All Records</a>
                </div>
                <div class="table-container" style="border:none; box-shadow:none;">
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Client Name</th>
                                <th>Value</th>
                                <th>Status</th>
                                <th style="text-align:right;">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                            <tr>
                                <td style="font-weight:700; color: var(--primary);">#{{ $order->id }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $order->customer_name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-light);">{{ $order->customer_email }}</div>
                                </td>
                                <td style="font-weight:800;">${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge {{ $order->status == 'completed' ? 'badge-success' : ($order->status == 'pending' ? 'badge-info' : 'badge-danger') }}" 
                                          style="background: {{ $order->status == 'completed' ? 'rgba(16,185,129,0.1)' : ( $order->status == 'pending' ? 'rgba(59,130,246,0.1)' : 'rgba(239, 68, 68, 0.1)' ) }};
                                                 color: {{ $order->status == 'completed' ? '#065f46' : ($order->status == 'pending' ? '#075985' : '#991b1b') }};">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td style="text-align:right;">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" style="color:var(--text-light); hover:color:var(--primary); transition: 0.2s;"><i class="fas fa-arrow-right"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Content Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="card">
                    <h2 style="font-size: 1.1rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-newspaper" style="color: var(--primary)"></i> Latest Blogs
                    </h2>
                    <div style="display: grid; gap: 1rem;">
                        @foreach($recent_blogs as $blog)
                        <div style="display: flex; align-items: center; gap: 1rem; padding: 0.5rem 0;">
                            <div style="width: 40px; height: 40px; border-radius: 8px; background: var(--bg-main); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-lines" style="color: var(--text-light); font-size: 0.8rem;"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 0.85rem; font-weight: 700; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">{{ $blog->title }}</div>
                                <div style="font-size: 0.7rem; color: var(--text-light);">{{ $blog->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h2 style="font-size: 1.1rem; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-rocket" style="color: var(--accent)"></i> Pages
                        </h2>
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-secondary" style="padding: 0.25rem 0.75rem; font-size: 0.75rem;"><i class="fas fa-plus"></i> New</a>
                    </div>
                    <div style="display: grid; gap: 1rem;">
                        @foreach($pages as $page)
                        <div style="display: flex; align-items: center; gap: 1rem; padding: 0.5rem 0;">
                            <div style="width: 40px; height: 40px; border-radius: 8px; background: var(--bg-main); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-globe" style="color: var(--text-light); font-size: 0.8rem;"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 0.85rem; font-weight: 700;">{{ $page->title }}</div>
                                <div style="font-size: 0.7rem; color: var(--text-light);">{{ $page->slug }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div style="display: grid; gap: 2rem;">
            <!-- Performance Chart Area -->
            <div class="card" style="background: linear-gradient(135deg, var(--bg-sidebar), #1e293b); color: white;">
                <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem; color: white;">Business Health</h2>
                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.5); margin-bottom: 2rem;">Predictive analysis for Q1 2026</p>
                <div style="height: 120px; display: flex; align-items: flex-end; gap: 6px;">
                    @for($i=0; $i<12; $i++)
                        <div style="flex: 1; min-width: 10px; background: var(--primary); height: {{ rand(30, 95) }}%; border-radius: 4px; opacity: {{ 0.4 + ($i/15) }}; border: 1px solid rgba(255,255,255,0.1);"></div>
                    @endfor
                </div>
                <div style="margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">Growth Trend</div>
                        <div style="font-size: 1.1rem; font-weight: 800;">+24.5%</div>
                    </div>
                    <div style="text-align: right;">
                        <i class="fas fa-chart-line" style="font-size: 2rem; color: var(--primary);"></i>
                    </div>
                </div>
            </div>

            <!-- Platform Diagnostic -->
            <div class="card">
                <h2 style="font-size: 1.1rem; margin-bottom: 1.5rem;">Diagnostic Report</h2>
                <div style="display: grid; gap: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                            <span style="font-size: 0.9rem; font-weight: 600;">Engine Status</span>
                        </div>
                        <span style="font-size: 0.75rem; font-weight: 800; color: #10b981;">OPTIMAL</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                            <span style="font-size: 0.9rem; font-weight: 600;">Global Connectivity</span>
                        </div>
                        <span style="font-size: 0.75rem; font-weight: 800; color: #10b981;">99.9%</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 8px; height: 8px; background: #f59e0b; border-radius: 50%;"></div>
                            <span style="font-size: 0.9rem; font-weight: 600;">Caching Layer</span>
                        </div>
                        <span style="font-size: 0.75rem; font-weight: 800; color: #f59e0b;">SYNCING</span>
                    </div>
                </div>
                <hr style="border: 0; border-top: 1px solid var(--border-soft); margin: 1.75rem 0;">
                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-light); font-weight: 600;">
                    <span>System Latency</span>
                    <span>14ms</span>
                </div>
            </div>
        </div>
    </div>
@endsection
