<template>
    <div class="container">
        <div class="row mt-5">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users Table</h3>

              <div class="card-tools">

                <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-user-plus"></i>&nbsp;Add New</button>
                
              </div>
            </div>
            <div class="card-body table-responsive no-padding">
              <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>
                    <a href="#"><i class="fa fa-edit fa-fw blue"></i></a>
                    <a href="#"><i class="fa fa-trash fa-fw red"></i></a>
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
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="createUser">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.name" type="text" name="name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Username">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.email" type="email" name="email"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email">
                  <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.password" type="password" name="password"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                  <has-error :form="form" field="password"></has-error>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Create</button>
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
                form:new Form({
                    name: '',
                    email: '',
                    password: '',
                })
            }
        },
        methods: {
            createUser(){
                this.form.post('api/user');

            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
