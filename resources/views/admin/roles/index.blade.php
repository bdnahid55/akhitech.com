@extends('admin.layouts.app')

@section('title', 'রোল ও পারমিশন')
@section('page_title', 'রোল ও পারমিশন ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল ইউজার রোলস</h3>
            @can('roles.manage')
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle mr-1"></i> নতুন রোল তৈরি করুন
                </a>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>রোলের নাম</th>
                            <th>পারমিশন সমূহ</th>
                            <th>যুক্ত ইউজার সংখ্যা</th>
                            <th style="width: 150px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $index => $role)
                            <tr>
                                <td>{{ $roles->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-weight-bold">
                                        @if ($role->name === 'Super Admin')
                                            <i class="fas fa-shield-alt text-danger mr-1"></i>
                                            <span class="text-danger">{{ $role->name }}</span>
                                            <span class="badge badge-danger ml-1">সুপার এডমিন</span>
                                        @else
                                            <i class="fas fa-user-tag text-primary mr-1"></i>
                                            <span>{{ $role->name }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($role->name === 'Super Admin')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-double mr-1"></i>সকল পারমিশন (ফুল এক্সেস)
                                        </span>
                                    @else
                                        <span class="badge badge-info mr-1">
                                            {{ $role->permissions->count() }}টি পারমিশন
                                        </span>
                                        <small class="text-muted">
                                            ({{ Str::limit($role->permissions->pluck('name')->implode(', '), 60) }})
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-users mr-1"></i>{{ $role->users_count }} জন
                                    </span>
                                </td>
                                <td class="text-right">
                                    @can('roles.manage')
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-info mr-1" title="সম্পাদনা">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($role->name !== 'Super Admin')
                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই রোলটি মুছে ফেলতে চান?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="ডিলিট" {{ $role->users_count > 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled title="সুপার এডমিন রোল মোছা যাবে না">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">কোনো রোল পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($roles->hasPages())
            <div class="card-footer clearfix">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
@endsection
