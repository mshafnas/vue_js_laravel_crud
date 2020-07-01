<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <title>Laravel</title>
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <style>
            body{
                background: #fff;
            }
            h4{
                position: relative;
                top: 15px;
                margin-bottom: 5%;
            }
            .hidden{
                display: none;
            }
            #table{
                margin-top: 25px !important;
            }
        </style>

    </head>
    <body>
        <div class="container">
            <div id="app">
                <h4 class="text-center">Enter Details</h4>
                <div class="row justify-content-center">
                    <div class="form-group col-md-8 col-sm-8">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" 
                            v-model="newData.name" placeholder="Enter Your Name" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-8 col-sm-8">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-control" 
                            v-model="newData.age" placeholder="Enter Your Age" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-8 col-sm-8">
                        <label for="profession">Profession</label>
                        <input type="text" name="profession" id="profession" class="form-control" 
                            v-model="newData.profession" placeholder="Enter Your Profession" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <p class="text-center alert alert-danger" v-bind:class="{hidden: hasError}"> Please Fill All The Fields!</p>
                </div>
                <div class="row justify-content-center mb-2">
                    <button class="btn btn-success btn-block" style="width: 50%;" @click.prevent="createData()">ADD</button>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6 mb-2">
                        <label for="search">Search by Name</label>
                        <input type="text" name="search" id="search" class="form-control" v-model="search">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <table class="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Profession</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fliteredData">
                                <td>@{{item.id}}</td>
                                <td>@{{item.name}}</td>
                                <td>@{{item.age}}</td>
                                <td>@{{item.profession}}</td>
                                <td id="show-modal" @click="showModal = true; setVal(item.id, item.name, item.age, item.profession)"
                                    class="btn btn-primary btn-sm mb-2">Edit</td>
                                <td @click.prevent="deleteData(item)" class="btn btn-danger btn-sm" style="margin-left: 15px !important">Delete</td>

                            </tr>
                        </tbody>
                    </table>
                    <nav aria-label="...">
                        <ul class="pagination">
                          <li class="page-item"  v-bind:class="[{disabled: !pagination.prev_page_url}]">
                            <a class="page-link" href="#" @click="fetchPaginateData(pagination.prev_page_url)">Previous</a>
                          </li>
                          
                          <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]" >
                            <a class="page-link" href="#" @click="fetchPaginateData(pagination.next_page_url)">Next</a>
                          </li>
                        </ul>
                      </nav>
                    <modal v-if="showModal" @close="showModal=false">
                        <h3 slot="header">Edit Data</h3>
                        <div slot="body">
                            <input type="hidden" name="edit_id" id="edit_id" class="form-control" 
                                required :value="this.edit_id">
                            <input type="text" name="edit_name" id="edit_name" class="form-control" 
                                placeholder="Enter Your Name":value="this.edit_name" required><br/>

                            <input type="number" name="edit_age" id="edit_age" class="form-control" 
                                placeholder="Enter Your Age":value="this.edit_age" required><br/>

                            <input type="text" name="edit_profession" id="edit_profession" class="form-control" 
                                placeholder="Enter Your Profession":value="this.edit_profession" required>
                        </div>
                        <div slot="footer">
                            <button type="button" class="btn btn-default" @click="showModal = false">Cancel</button>
                            <button type="button" class="btn btn-primary" @click="editData()">Update</button>
                        </div>
                    </modal>
                </div>
            </div>
        </div>
    </body>
</html>
