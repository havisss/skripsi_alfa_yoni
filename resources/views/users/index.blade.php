@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0 text-primary-custom fw-bold">User Management</h2>
    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus"></i> Add New User
    </button>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="usersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="fw-medium">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary me-2" onclick="editUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', {{ json_encode($user->permissions ?? []) }})">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-outline-danger disabled" title="You cannot delete yourself">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Menu Access Permissions</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="qc.upload" id="perm_qc_upload">
                                    <label class="form-check-label" for="perm_qc_upload">Upload Auto QC</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="qc.manual" id="perm_qc_manual">
                                    <label class="form-check-label" for="perm_qc_manual">Manual QC Input</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="qc.history" id="perm_qc_history">
                                    <label class="form-check-label" for="perm_qc_history">QC History</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="products.index" id="perm_products">
                                    <label class="form-check-label" for="perm_products">Master Product</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="inventory.index" id="perm_inventory">
                                    <label class="form-check-label" for="perm_inventory">Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="inventory.mutations" id="perm_mutations">
                                    <label class="form-check-label" for="perm_mutations">Stock Mutation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="reports.index" id="perm_reports">
                                    <label class="form-check-label" for="perm_reports">All Reports</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="users.index" id="perm_users">
                                    <label class="form-check-label" for="perm_users">User Management</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control" minlength="8">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Menu Access Permissions</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm" type="checkbox" name="permissions[]" value="qc.upload" id="edit_perm_qc_upload">
                                    <label class="form-check-label" for="edit_perm_qc_upload">Upload Auto QC</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input edit-perm" type="checkbox" name="permissions[]" value="qc.manual" id="edit_perm_qc_manual">
                                    <label class="form-check-label" for="edit_perm_qc_manual">Manual QC Input</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input edit-perm" type="checkbox" name="permissions[]" value="qc.history" id="edit_perm_qc_history">
                                    <label class="form-check-label" for="edit_perm_qc_history">QC History</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input edit-perm" type="checkbox" name="permissions[]" value="products.index" id="edit_perm_products">
                                    <label class="form-check-label" for="edit_perm_products">Master Product</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm" type="checkbox" name="permissions[]" value="inventory.index" id="edit_perm_inventory">
                                    <label class="form-check-label" for="edit_perm_inventory">Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input edit-perm" type="checkbox" name="permissions[]" value="inventory.mutations" id="edit_perm_mutations">
                                    <label class="form-check-label" for="edit_perm_mutations">Stock Mutation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input edit-perm" type="checkbox" name="permissions[]" value="reports.index" id="edit_perm_reports">
                                    <label class="form-check-label" for="edit_perm_reports">All Reports</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input edit-perm" type="checkbox" name="permissions[]" value="users.index" id="edit_perm_users">
                                    <label class="form-check-label" for="edit_perm_users">User Management</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            "order": [[2, "desc"]]
        });

        $('.delete-form').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    function editUser(id, name, email, permissions) {
        $('#editUserForm').attr('action', `/users/${id}`);
        $('#edit_name').val(name);
        $('#edit_email').val(email);
        
        // Reset checkboxes
        $('.edit-perm').prop('checked', false);
        // Check the ones user has
        if(permissions && permissions.length > 0) {
            permissions.forEach(function(perm) {
                $(`.edit-perm[value="${perm}"]`).prop('checked', true);
            });
        }
        
        $('#editUserModal').modal('show');
    }
</script>
@endpush
@endsection
