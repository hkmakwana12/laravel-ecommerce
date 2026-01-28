<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        <h1 class="text-base-content text-3xl font-semibold">Dashboard</h1>

        <!-- Statistics Cards (Flyon `stats` style) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stats max-sm:w-full">
                <div class="stat">
                    <div class="stat-figure">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-primary/20 text-primary size-10 rounded-full">
                                <span class="icon-[tabler--shopping-cart] size-6"></span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-title">Total Orders</div>
                    <div class="stat-value">{{ $totalOrders }}</div>
                </div>
            </div>

            <div class="stats max-sm:w-full">
                <div class="stat">
                    <div class="stat-figure">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-secondary/20 text-secondary size-10 rounded-full">
                                <span class="icon-[tabler--package] size-6"></span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-title">Total Products</div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                </div>
            </div>

            <div class="stats max-sm:w-full">
                <div class="stat">
                    <div class="stat-figure">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-accent/20 text-accent size-10 rounded-full">
                                <span class="icon-[tabler--users] size-6"></span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                </div>
            </div>

            <div class="stats max-sm:w-full">
                <div class="stat">
                    <div class="stat-figure">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-info/20 text-info size-10 rounded-full">
                                <span class="icon-[tabler--currency-dollar] size-6"></span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-title">Total Revenue</div>
                    <div class="stat-value">@money($totalRevenue)</div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Orders</h3>
            </div>
            <div class="overflow-x-auto border-t border-base-content/20">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td class="font-medium">#{{ $order->order_number }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>
                                    <span
                                        class="badge badge-soft badge-{{ $order->status->color() }}">{{ $order->status->label() }}</span>
                                </td>
                                <td class="font-medium">@money($order->grand_total)</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin>
