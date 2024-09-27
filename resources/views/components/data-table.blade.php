@props([
    'columns',      // Array of columns with their label and field names (e.g., ['id', 'title', 'location'])
    'ajaxUrl',      // The route for DataTables AJAX data fetch
])

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
        table.dataTable tbody tr {
            background-color: rgb(255 255 255 / 0.1);
        }

        label {
            color: white;
        }

        .dataTables_info {
            color: white !important;
        }

        .paginate_button > a{
            color: white !important;
        }

        .active {
            background-color: rgb(255 255 255 / 0.1);
        }
    </style>
</head>
<div class="container mx-auto my-10 p-8 bg-white/5 shadow-md rounded-lg">
    <div class="overflow-x-auto">
        <table id="data-table" class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-white/10">
                <tr>
                    @foreach ($columns as $column)
                    <th class="px-6 py-3 text-left text-sm font-medium text-white uppercase tracking-wider">
                        {{ $column['label'] }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white/5 divide-y divide-gray-200 text-white/60"></tbody>
        </table>
    </div>
</div>

{{-- Edit User Modal --}}
<x-modal id="editModal" />
{{-- ---------------- --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ $ajaxUrl }}',
                type: 'GET',
                dataSrc: function (json) {
                    console.log('Data received:', json);  // Log the data to inspect it
                    return json.data; // Return the actual data for DataTables to use
                },
                error: function (xhr, error, thrown) {
                    console.error('Error fetching data:', error, xhr); // Log errors if any
                }
            },
            // columns: json(array_map(fn($col) => ['data' => $col['field']], $columns)),
            columns: [
                { data: 'id' },
                { data: 'title' },
                { data: 'salary' },
                { data: 'location' },
                { data: 'company' },
                { 
                    data: 'created_at'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        // Use the `row` parameter to access the full row data if needed
                        return `
                            <a href="javascript:void(0);" class="px-3 py-1 rounded-md bg-indigo-600 text-white hover:bg-indigo-800" onclick="editUser(${data})">Edit</a> | 
                            <a href="javascript:void(0);" class="px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-800" onclick="deleteUser(${data})">Delete</a>
                        `;
                    },
                    orderable: false, // Prevent ordering by the actions column
                    searchable: false // Prevent searching in the actions column
                }
            ],
            responsive: true
        });
    });

    function editUser(id) {
        
        console.log("Editing user with ID: " + id);
        // Open the edit modal and load user data via AJAX if needed
        $.get('/jobs/' + id + '/edit', function(data) {
            $('#edit-job-id').val(data.id);
            $('#job-title').val(data.title);
            $('#job-salary').val(data.salary);
            $('#job-location').val(data.location);
            $('#editModal').show();
        });
    }

    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        const jobId = $('#edit-job-id').val();
        const formData = $(this).serialize();

        console.log('Jobr ID: ', jobId);
        console.log('Form Data: ', formData);
        
        $.post('/jobs/' + jobId, formData, function(response) {
            if (response.success) {
                $('#editModal').hide();
                $('#data-table').DataTable().ajax.reload(); // Reload the DataTable without reloading the page
                alert('User updated successfully.');
            }
        });
    });

    function deleteUser(id) {
        // Implement your delete logic (e.g., send an AJAX request to delete the user)
        if (confirm("Are you sure you want to delete this job?")) {
            $.ajax({
                url: '/jobs/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    // Reload the DataTable after deleting the user
                    $('#data-table').DataTable().ajax.reload();
                    alert('Job deleted successfully.');
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        }
    }

</script>