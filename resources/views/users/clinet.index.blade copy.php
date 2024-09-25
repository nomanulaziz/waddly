<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    @vite(['resources/css/app.css'])

    <title>User Management</title>
</head>
<body>

    <div class="container mx-auto my-10 p-8 bg-white shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <h2 class="text-xl font-bold my-10">Manage Users</h2>
            <table id="data-table" class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Id
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                  
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Edit User Modal --}}
    <x-modal id="editUserModal" />
    {{-- ---------------- --}}
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('users.data') }}',
                    type: 'GET'
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                            <a href="javascript:void(0);" class="px-3 py-1 rounded-md bg-indigo-600 text-white hover:bg-indigo-800" onclick="editUser(${data})">Edit</a>
                            <a href="javascript:void(0);" class="px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-800 btn btn-danger btn-sm" onclick="deleteUser(${data})">Delete</a>
                            `;
                        }
                }
            ]
        });
    });
    
    // open edit user modal
    function editUser(id) 
    {
        $.get('/users/' + id + '/edit', function(data) {
            $('#edit-user-id').val(data.id);
            $('#edit-name').val(data.name);
            $('#edit-email').val(data.email);
            $('#editUserModal').show();
        });
    }


    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        const userId = $('#edit-user-id').val();
        const formData = $(this).serialize();

        console.log('User ID: ', userId);
        console.log('Form Data: ', formData);
        
        $.post('/users/' + userId, formData, function(response) {
            if (response.success) {
                $('#editUserModal').hide();
                $('#data-table').DataTable().ajax.reload(); // Reload the DataTable without reloading the page
                alert('User updated successfully.');
            }
        });
    });
    
    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '/users/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#data-table').DataTable().ajax.reload(); // Reload DataTable
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        }
    }
    
    function closeModal() {
        $('#editUserModal').hide();
    }
    </script>

</body>
