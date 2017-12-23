<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Member</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button"
                            class="btn btn-link btn-xs"
                            title="New Member"
                            onclick="new_member()"><i class="fa fa-plus">&#160;</i> Add New Member
                    </button>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Hire of date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /#page-wrapper -->


<!-- Modal -->
<div class="modal fade" id="modal_member" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_member" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3" for="mem_code">Code</label>
                        <div class="col-md-8">
                            <input name="mem_code" placeholder="Code" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="mem_name">Name</label>
                        <div class="col-md-8">
                            <input name="mem_name" placeholder="Name" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="mem_gender">Gender</label>
                        <div class="col-md-8">
                            <select class="form-control" id="mem_gender" name="mem_gender">
                                <option value="">-- Select Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="mem_phone">Phone</label>
                        <div class="col-md-8">
                            <input name="mem_phone" placeholder="Phone" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="mem_dob">Hired of date</label>
                        <div class="col-md-8">
                            <input name="mem_dob" placeholder="Hired of date" class="form-control datepicker" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close">&#160;</i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save">&#160;</i> Save</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    var save_method;
    var table;
    $(document).ready(function() {
        table = $('#dataTables-example').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            responsive: true,
            "ajax": {
                "url": "<?php echo base_url('fetch_member');?>",
                "type": "POST",
                "data": {
                    '<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>'
                }
            },
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false //set not orderable
            }]
        });// table fetch data


        //save data
        $('#form_member').submit(function(e){
            e.preventDefault();
            var url;
            if(save_method=="add") url="<?php echo base_url()?>admin/member/add_member";

            $.ajax({
                url     : url,
                method  : "POST",
                data    : new FormData(this),
                dataType : "JSON",
                contentType : false,
                cache   : false,
                processData : false,
                success :function(data){
                    if(data.status){
                        $('#modal_member').modal('hide');
                        reload_table();
                    }
                    else{
                        for(var i=0;   i < data.inputerror.length;  i++){
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                        }
                    }
                },
                error   :function(){
                    alert("Error adding");
                }
            });
        });//end form submit


        $("input").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });//end jquery element

    function new_member(){
        $('#modal_member').modal('show');
        $('.modal-title').text('New Member');
        save_method="add";
    }//end new_member
    function reload_table()
    {
        table.ajax.reload(null,false);
    }//end
</script>