/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('test', require('./components/test.vue'));

// Vue.component('modal', {
//     template: '#modal-template'
// });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        newData: {'name': '', 'age': '', 'profession': ''},
        hasError: true,
        showModal: false,
        data: [],
        search: '',
        edit_id: '',
        edit_name: '',
        edit_age: '',
        edit_profession: '',
        url: 'getData',
        pagination: []
    },
    // mounted is used to load the data when page loads
    mounted: function mounted(){
        this.getData();
    },
    
    methods: {
        // method for get data
        getData: function getData(){
            // create instance of the method
            var _this = this;
            axios.get(this.url).then(function (response){
                _this.data = response.data.data;
                _this.makePagination(response.data)
            });
        },
        // method for pagination
        makePagination: function makePagination(data){
            let pagination = {
                current_page: data.current_page,
                last_page: data.last_page,
                next_page_url: data.next_page_url,
                prev_page_url: data.prev_page_url
            }
            this.pagination = pagination;
        },
        // get paginate data
        fetchPaginateData(url){
            this.url = url;
            this.getData();
        },
        // method for add data
        createData: function createData(){
            var input = this.newData;
            var _this = this;
            // validation
            if (input['name'] == '' || input['age'] == '' || input['profession'] == '') {
                this.hasError = false;
            }
            else{
                this.hasError = true;
                axios.post('/storeData', input).then(function (response){
                    _this.newData = {'name': '', 'age': '', 'profession': ''}
                    _this.getData(); 
                });
            }
        },
        // get values before update
        setVal(val_id, val_name, val_age, val_profession){
            this.edit_id = val_id;
            this.edit_name = val_name;
            this.edit_age = val_age;
            this.edit_profession = val_profession;
        },
        editData: function editData(){
            var _this = this;
            // store input values 
            var val_id = document.getElementById("edit_id").value;
            var val_name = document.getElementById("edit_name").value;
            var val_age = document.getElementById("edit_age").value;
            var val_profession = document.getElementById("edit_profession").value;

            // send input values and id to the controller
            axios.post('/editData/' + val_id, {'val1': val_name, 'val2': val_age, 'val3': val_profession}).then(function (response){
                _this.getData();
                _this.showModal = false;
            });
            
        },
        // method for delete data
        deleteData: function deleteData(item){
            var _this = this;
            axios.post('/deleteData/' + item.id).then(function (response){
                _this.getData();
            });
        }
    },
    computed: {
        fliteredData: function filteredData(){
            return  this.data.filter((item) => {
                return item.name.includes(this.search)
            });
        }
    },
    
});
