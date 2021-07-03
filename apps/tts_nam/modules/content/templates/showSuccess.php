<!-- apps/frontend/templates/layout.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>test</title>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!--    --><?php //include_javascripts(); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
<!--    --><?php //include_stylesheets(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<p align="center">Test Sf</p>
<i class="fa fa-search"></i> <input placeholder="Tim kiem..." name="search" id="searching"  oninput="postSearch(this.value)" style="width: 300px" />
<br>
<br>
<button class="btn btn-success" id="addnewbtn">Add new <i class="fa fa-plus"></i></button>
<!--<p class="title">nam nguyen</p>-->
<?php $customerCate = Doctrine::getTable('CustomerCategory')
    ->createQuery()
    ->execute(); ?>
<div>
    <table class="table table-striped">
        <tr>
<!--            <th>STT</th>-->
            <th>ID</th>
            <th>Name</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <tbody id="appendData">
        <?php foreach ($customerCate as $key => $value): ?>
            <tr class="customer<?php echo $value->getId() ?>">
<!--                <td>--><?php //echo $key ?><!--</td>-->
                <td>
                    <?php echo $value->getId() ?>
                </td>
                <td><?php echo $value->getName() ?></td>
                <!--                <td><form method="get" action="--><?php //url_for('content/deletepost') ?><!--">-->
                <!--                        <input hidden  name="id" value="--><?php //echo $value->getId() ?><!--"/>-->
                <!--                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>-->
                <!--                    </form></td>-->
                <td><a
                       class="btn btn-danger deletePost" data-id="<?php echo $value->getId() ?>" data-name="<?php echo $value->getName()?>"><i
                                class="fa fa-trash"></i></a></td>
                <td><a class="btn btn-info customerUpdate" data-id="<?php echo $value->getId()?>" data-name="<?php echo $value->getName()?>"><i class="fa fa-edit"></i></a></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

<!-- Modal Create-->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Customer Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="mainForm" action="<?php echo url_for('send-post') ?>">
                <div class="modal-body">
                    <p>Add Title:</p>
                    <br>
                    <input class="form-control" name="title"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary form-control" data-dismiss="modal">Close</button>
                    <button type="submit" id="confirmcreate" class="btn btn-success form-control">Create <i class="fa fa-plus"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateForm" method="post">
                <div class="modal-body">
                        <p>Title</p>
                        <br>
                        <input class="form-control" id="updateTitleInput" name="name" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary form-control" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary form-control">Update <i class="fas fa-check"></i></button>
                </div>
            </form>


        </div>
    </div>
</div>
<!--end of modal update-->
<script type="text/javascript">
    const URL_SF = 'http://127.0.0.1/tts_nam_dev.php/content/';
    $('#addnewbtn').click(function () {
        $('#createModal').modal('show');
    });
    $('#confirmcreate').click(function () {
        $('#createModal').modal('hide');
    });

    $('#mainForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: URL_SF+'sendpost',
                method: 'post',
                dataType: 'json',
                data: $('#mainForm').serialize(),
                success: function (data) {
                    $('#appendData').append(data.htmlData);
                    console.log(data);
                    toastr.success('Them thanh cmn cong');
                },
                error: function (response) {
                }
            });
    });



    $('#appendData').on('click', '.deletePost', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let name = $(this).data('name');
        Swal.fire({
            title: 'Bạn có chắc xoá '+ name + ' không?',
            text: 'Việc xóa sẽ mất hết dữ cmn liệu, đồng ý?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#dd3333',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy bỏ',

        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: URL_SF+'deletepost?id=' + id,
                    method: 'post',
                    data: {
                        id: id
                    },
                    success: function (responseSuccess) {
                        $('.customer'+id).remove();
                        toastr.warning('Da xoa thanh cmn cong');
                    },
                    error: function (response) {
                    }
                });
                Swal.fire(
                    'Da xoa!',
                    'Ban da xoa thanh cong.',
                    'success'
                )
            }
        })

    });

    let updateId ;
    $('#appendData').on('click','.customerUpdate', function () {
            $('#updateModal').modal('show');
            let name = $(this).data('name');
            updateId = $(this).data('id');
            $('#updateTitleInput').val(name);

    });

    $('#updateForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: URL_SF+"update?id="+updateId,
            method: 'post',
            data: $('#updateForm').serialize(),
            dataType: 'JSON',
            success: function (responseData) {
                // console.log(responseData.htmlData)
                toastr.success('Update thanh cmn cong');
                $('.customer'+updateId).replaceWith(responseData.htmlData);
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    function postSearch(value) {
        $.ajax({
            url: URL_SF+'search?search='+value,
            method: 'post',
            dataType: 'json',
            data: {search: value},
            success: function (responseData) {
                $('#appendData').html(responseData.data);
            },
            error: function (response) {
                console.log('error'+ response);
            }
        });
    }
</script>
</body>
</html>
