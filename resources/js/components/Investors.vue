<template>
    <div class="container">
        <div class="row mt-5">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Investors List</h3>

              <div class="card-tools">

                <button class="btn btn-primary" @click="newModal"><i class="fa fa-user-plus"></i>&nbsp;Add New</button>
                
              </div>
            </div>
            <div class="card-body table-responsive no-padding">
              <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Nos Share</th>
                        <th>Investment Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <tr v-for=" investor in investors" :key="investor.id">
                  <td>{{ investor.first_name }} {{ investor.last_name }}</td>
                  <td>{{ investor.email }}</td>
                  <td>{{ investor.contact_no }}</td>
                  <td>{{ investor.nos_share }}</td>
                  <td>{{ investor.invst_amt }}</td>
                  <td>
                    <a href="#" @click="editModal(investor)"><i class="fa fa-edit fa-fw blue"></i></a>
                    <a href="#" @click="deleteInvestor(investor.id)"><i class="fa fa-trash fa-fw red"></i></a>
                  </td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- Modal -->
        <div class="modal fade" id="addInvestorModal" tabindex="-1" role="dialog" aria-labelledby="addInvestorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode" id="addInvestorModalLabel">Add New Investor</h5>
                <h5 class="modal-title" v-show="editmode" id="addInvestorModalLabel">Edit Investor Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="editmode  ? updateInvestor() : createInvestor()" id="investorForm">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col">
                    <input v-model="form.first_name" type="text" name="first_name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }" placeholder="First Name">
                    <has-error :form="form" field="first_name"></has-error>
                  </div>
                  <div class="col">
                    <input v-model="form.last_name" type="text" name="last_name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }" placeholder="Last Name">
                    <has-error :form="form" field="last_name"></has-error>
                  </div>
                </div>
                <div class="form-row" style="margin-top:5px;">
                  <div class="col">
                    <input v-model="form.email" type="text" name="email"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email Address">
                    <has-error :form="form" field="email"></has-error>
                  </div>
                  <div class="col">
                    <input v-model="form.contact_no" type="text" name="contact_no"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('contact_no') }" placeholder="e.g. +880123456789">
                    <has-error :form="form" field="contact_no"></has-error>
                  </div>
                </div>
                <div class="form-row" style="margin-top:5px;">
                  <div class="col">
                    <input v-model="form.nos_share" type="number" min="1" name="nos_share"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nos_share') }" placeholder="Number of Share">
                    <has-error :form="form" field="nos_share"></has-error>
                  </div>
                  <div class="col">
                    <input v-model="form.invst_amt" type="number" min="100" name="invst_amt"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('invst_amt') }" placeholder="e.g. $. 50000">
                    <has-error :form="form" field="invst_amt"></has-error>
                  </div>
                </div>
                <div class="form-row" style="margin-top:5px;">
                  <div class="col">
                    <input v-model="form.ref_no" type="text" min="1" name="ref_no"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('ref_no') }" placeholder="Share Certificate number">
                    <has-error :form="form" field="ref_no"></has-error>
                  </div>
                  <div class="col">
                    <textarea row="3" name="address" v-model="form.address" class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                    </textarea>
                    <has-error :form="form" field="address"></has-error>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" v-show="!editmode" class="btn btn-success">Create</button>
                <button type="submit" v-show="editmode" class="btn btn-success">Update</button>
              </div>
              </form>
            </div>
          </div>
        </div>



    </div>
</template>

<script>
    export default {
        data(){
            return{
                editmode: false,
                investors: {},
                form:new Form({
                    id: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    contact_no: '',
                    nos_share: '',
                    invst_amt: '',
                    ref_no: '',
                    address: '',
                })
            }
        },
        methods: {
            editModal(data){
              this.form.reset();
              this.editmode = true;
              $("#addInvestorModal").modal("toggle"); 
              this.form.fill(data);
            },
            newModal(){
              this.form.reset();
              this.editmode = false;
              $("#addInvestorModal").modal("toggle"); 
            },            
            loadInvestors(){
              axios.get('api/investor').then(({data})=>(this.investors = data.data));
            },
            createInvestor(){
                this.$Progress.start();
                this.form.post('api/investor');
                $("#addInvestorModal").modal("toggle");                
                Fire.$emit("AfterAction");
                toast.fire({
                  icon: 'success',
                  title: 'Investor created successfully'
                })
                this.$Progress.finish();
            },
            updateInvestor(){
                this.$Progress.start();
                this.form.put('api/investor/'+this.form.id)
                .then(() => {
                  // success
                  $("#addInvestorModal").modal("toggle");                
                  Fire.$emit("AfterAction");
                  swal(
                    'Updated',
                    'Investor Information has been uppdated.',
                    'success'
                  );
                  this.$Progress.finish();
                })
                .catch(() => {
                  this.$Progress.fail();
                });
                
            },
            deleteInvestor(id){
              swal.fire({
                title: 'Are you sure to remove this Investor?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                this.$Progress.start();
                // send request to server
                this.form.delete('api/investor/'+id)
                .then(() => {

                  this.$Progress.finish();
                  swal.fire(
                    'Deleted!',
                    'Investor has been deleted.',
                    'success'
                  );
                  Fire.$emit("AfterAction");

                }).catch(() => {

                  this.$Progress.fail();

                  swal.fire(
                    'Alas!',
                    'Investor has not been deleted.',
                    'warning'
                  )

                });
                
              })


            }
        },
        created() {
            this.loadInvestors();
            Fire.$on("AfterAction", ()=>{
              this.loadInvestors();
            });
        }
    }
</script>
