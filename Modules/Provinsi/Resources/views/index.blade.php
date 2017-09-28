@extends('layouts.dashboard')
@push('content-header')
<section class="content-header">
      <h1>
        Provinsi
        <small>Master Provinsi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-database"></i> Master Data</a></li>
        <li class="active">Master Provinsi</li>
      </ol>
    </section>
@endpush
@section('content')
    <div class="box box-primary" id="manage-vue">
        <div class="box-header">
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Tambah Data</button>
        </div>
        <div class="box-body">
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Data Provinsi</h4>
            </div>
            <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
            <div class="modal-body">
                     <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" class="form-control" v-model="newItem.provinsi">
                    <span v-if="formErrors['provinsi']" class="error text-danger">@{{ formErrors['provinsi'] }}</span>
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
            </div>
        </div>
        </div>

		<!-- Edit Item Modal -->
		<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
		      </div>
		      <div class="modal-body">
		      		<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
		      			<div class="form-group">
						<label for="title">Nama Provinsi:</label>
						<input type="text" name="title" class="form-control" v-model="fillItem.provinsi" />
						<span v-if="formErrorsUpdate['provinsi']" class="error text-danger">@{{ formErrorsUpdate['provinsi'] }}</span>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
		      		</form>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
            <table class="table borderd-stripped">
                <thead>
                    <th>Nama Provinsi</th>
                    <th>Action</th>
                </thead>
                <tbody>
                <tr v-for="item in items">
                    <td>@{{ item.namaprovinsi }}</td>
                    <td>	
                        <button class="btn btn-primary" @click.prevent="editItem(item)">Edit</button>
                        <button class="btn btn-danger" @click.prevent="deleteItem(item)">Delete</button>
                    </td>
			    </tr>
                </tbody>
                
            </table>
            <nav>
	        <ul class="pagination">
	            <li v-if="pagination.current_page > 1">
	                <a href="#" aria-label="Previous"
	                   @click.prevent="changePage(pagination.current_page - 1)">
	                    <span aria-hidden="true">«</span>
	                </a>
	            </li>
	            <li v-for="page in pagesNumber"
	                v-bind:class="[ page == isActived ? 'active' : '']">
	                <a href="#"
	                   @click.prevent="changePage(page)">@{{ page }}</a>
	            </li>
	            <li v-if="pagination.current_page < pagination.last_page">
	                <a href="#" aria-label="Next"
	                   @click.prevent="changePage(pagination.current_page + 1)">
	                    <span aria-hidden="true">»</span>

	                </a>
	            </li>
	        </ul>
	    </nav>
        </div>
    </div>
@stop
@push('script')
<script>
Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");


new Vue({


  el: '#manage-vue',


  data: {

    items: [],

    pagination: {

        total: 0, 

        per_page: 2,

        from: 1, 

        to: 0,

        current_page: 1

      },

    offset: 4,

    formErrors:{},

    formErrorsUpdate:{},

    newItem : {'provinsi':''},

    fillItem : {'provinsi':'','id':''}

  },


  computed: {

        isActived: function () {

            return this.pagination.current_page;

        },

        pagesNumber: function () {

            if (!this.pagination.to) {

                return [];

            }

            var from = this.pagination.current_page - this.offset;

            if (from < 1) {

                from = 1;

            }

            var to = from + (this.offset * 2);

            if (to >= this.pagination.last_page) {

                to = this.pagination.last_page;

            }

            var pagesArray = [];

            while (from <= to) {

                pagesArray.push(from);

                from++;

            }

            return pagesArray;

        }

    },

    mounted:function(){
           // console.log('helo dunia')
            this.getVueItems(this.pagination.current_page);
    },
  methods : {


        getVueItems: function(page){

          this.$http.get('/provinsi/api?page='+page).then((response) => {
            console.log(response.data.data.data)
            //this.$set('items', response.data.data.data);
            this.$set(this, 'items', response.data.data.data);
            this.$set(this, 'pagination', response.data.pagination);
            //this.$set('pagination', response.data.pagination);

          });

        },


        createItem: function(){

		  var input = this.newItem;

		  this.$http.post('/provinsi/api',input).then((response) => {

		    this.changePage(this.pagination.current_page);

			this.newItem = {'provinsi':''};

			$("#create-item").modal('hide');
            alert('data sukses di simpan')
			//toastr.success('Item Created Successfully.', 'Success Alert', {timeOut: 5000});

		  }, (response) => {

			this.formErrors = response.data;

	    });

	},


      deleteItem: function(item){

        this.$http.delete('provinsi/api/'+item.id).then((response) => {

            this.changePage(this.pagination.current_page);

            toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});

        });

      },


      editItem: function(item){
          this.fillItem.provinsi = item.namaprovinsi;
          this.fillItem.id = item.id;
          $("#edit-item").modal('show');
      },


      updateItem: function(id){
        var input = this.fillItem;
        this.$http.put('provinsi/api/'+id,input).then((response) => {
            this.changePage(this.pagination.current_page);
            this.fillItem = {'provinsi':'','id':''};
            $("#edit-item").modal('hide');
            alert('Data Terkirim')
            //toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
          }, (response) => {

              this.formErrorsUpdate = response.data;

          });

      },


      changePage: function (page) {

          this.pagination.current_page = page;

          this.getVueItems(page);

      }


  }


});
</script>
@endpush