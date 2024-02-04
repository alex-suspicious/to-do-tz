<!--Home.vue-->
<template>
	<div class="container">
		<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
		  <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
		    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
		  </a>

		  <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
		    <li><a href="/" class="nav-link px-2 link-secondary">Tasks</a></li>
		  </ul>

		  <div class="col-md-3 text-end">
		    <a type="button" class="btn btn-outline-primary me-2" v-if="!user" href="/login">Login</a>
		    <button type="button" class="btn btn-outline-primary me-2" v-if="user" @click="logout()">Logout</button>
		  </div>
		</header>

		<div>
		  <vue-good-table
		    :columns="columns"
		    :rows="rows"
		    :pagination-options="{
			    enabled: true,
			    mode: 'records',
			    perPage: 3,
			    position: 'top',
			    dropdownAllowAll: false,
			    setCurrentPage: 1,
		  	}"
		  />
		</div>

		<br>
		<form method="post" @submit.prevent="handleTaskPost" class="row" >
			<div class="col-sm-4" >
				<input type="string" class="form-control" placeholder="name" id="name" v-model="form.name" required>
			</div>
			<div class="col-sm-4" >
				<input type="email" class="form-control col-3" placeholder="email" id="email" v-model="form.email" required>
			</div>
			<div class="col-sm-3" >
				<input type="text" class="form-control col-sm-3" placeholder="text" id="text" v-model="form.text" required>
			</div>
			<div class="col-sm-1" >
				<button class="btn btn-primary w-100" type="submit">Post</button>
			</div>	    
		</form>
	</div>

</template>
<script>
    import { useRouter } from 'vue-router';
    import axios from 'axios';
    import { ref, reactive, onMounted } from 'vue'
    import { api_request } from '/resources/js/helpers';

    $(document).on("click",".mark-as-done",async function(){
    	var id = $(this).attr("id");

		const req = await api_request('post', '/api/tasks/done/toggle', {id: id});
    });

    $(document).on("change",".set-text",async function(){
    	var id = $(this).attr("index");
    	var text = $(this).val();

		const req = await api_request('post', '/api/tasks/set/text', {id: id, text: text});
    });

    export default {
        setup() {
			const user = ref();
		    let router = useRouter();
		    const columns = [
		      {
		        label: 'Name',
		        field: 'name',
		      },
		      {
		        label: 'Email',
		        field: 'email',
		      },
		      {
		        label: 'Task',
		        field: 'text',
		        html: true,
		      },
		      {
		        label: 'Status',
		        field: 'status',
		        html: true,
		      },
		    ];

		    const rows = ref([]);

			onMounted(() => {
				auth(),
				getTasks()
			});

		    const getTasks = async () => {
		        try {
		            const req = await api_request('get','/api/tasks/list')
		            var tempData = req.data.reverse();

		            if( user.value ){
		            	for( var i=0; i < tempData.length; i++ ){
		            		var checked = "";

			            	if( tempData[i]["status"] )
				            	checked = "checked";

				            tempData[i]["status"] = `
					            <div class="form-check">
								  <input class="form-check-input mark-as-done" type="checkbox" value="" id="`+tempData[i]["id"]+`" `+checked+`>
								  <label class="form-check-label" for="`+tempData[i]["id"]+`">
								    Done
								  </label>
								</div>`;   

							tempData[i]["text"] = `
					            <input class="form-control set-text" index="`+tempData[i]["id"]+`" value="`+tempData[i]["text"]+`" placeholder="task text">`;           	
			            }
		            }else{
		            	for( var i=0; i < tempData.length; i++ ){
			            	if( tempData[i]["status"] )
			            		tempData[i]["status"] = "Edited by Admin";		            	
			            	else
			            		tempData[i]["status"] = "Not done";
			            }
		            }

					rows.value = tempData;
		            console.log(rows);
		        } catch (e) {
		            await router.push('/')
		        }
		    }

		    const auth = async () => {
			    try {
		            const req = await api_request('get','/api/user')
		            user.value = req.data
		            console.log(user);
		        } catch (e) {
			        console.log("User is not logged in");
		        }
		    }

			const logout = async () => {
				try {
					const req = await api_request('post', '/auth/logout');
					window.location.reload();
				} catch (e) {
					window.location.reload();
				}
			};

			const form = reactive({
			    name: '',
			    email: '',
			    text: '',
			})

            const handleTaskPost = async () => {
                try {
                    const result = await axios.post('/api/tasks/create', form)
                    if (result.status === 200) {
                        window.location.reload();
                    }
                } catch (e) {
                    if(e && e.response.data && e.response.data.errors) {
                        errors.value = Object.values(e.response.data.errors)
                    } else {
                        errors.value = e.response.data.message || ""
                    }
                }
            }


		    return{
		    	rows,
		    	columns,
		    	user,
		    	logout,
		    	form,
		    	handleTaskPost,
		    }

        }
    }


</script>