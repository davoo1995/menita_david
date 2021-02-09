<!DOCTYPE html>
<html>
<head>
	<title>Prueba Menita</title>
	<!-- UIkit CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.16/dist/css/uikit.min.css" />

	<!-- UIkit JS -->
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.6.16/dist/js/uikit.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.6.16/dist/js/uikit-icons.min.js"></script>

	<!-- VUE JS -->
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

	<!-- AXIOS JS -->
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
	<div class="uk-container uk-padding" id="principal">
		<div uk-grid class="uk-child-width-1-3@m uk-child-width-1-2@s">

			<div class="uk-card uk-card-hover " v-for="post in posts">
			    <div class="uk-card-header">
			        <div class="uk-grid-small uk-flex-middle" uk-grid>
			            <div class="uk-width-auto">
			                <img class="uk-border-circle" width="40" height="40" src="https://upload.wikimedia.org/wikipedia/commons/9/99/Elvis_Presley_promoting_Jailhouse_Rock.jpg">
			            </div>
			            <div class="uk-width-expand">
			                <h3 class="uk-card-title uk-margin-remove-bottom" >{{post.title}}</h3>
			            </div>
			        </div>
			    </div>
			    <div class="uk-card-body">
			        <p>{{post.msg}}</p>
			    </div>
			    <div class="uk-card-footer">
			        <div uk-grid>
			        		<div class="uk-width-expand"><input class="uk-input" type="text" v-model="coment"></div>
			        	<div class="uk-width-auto">
				        <button  class="uk-button uk-button-primary uk-button-small" v-on:click="addComment(post.id)">AGREGAR</button>
				    </div>
			        
					    
					</div>
			          <div :key="comment['.key']" v-for="comment in comments"  v-if="comment.postId === post.id" class="uk-inline uk-width-1-1 uk-padding-small">
			       	<button  class="uk-button uk-button-danger uk-button-small uk-position-top-right" v-on:click="deleteComment(comment.id)">X</button>
			       	{{comment.body}}
			       </div>
			    </div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	var app = new Vue({
	  el: '#principal',
	  data () {
	     return {
	      coment: '',
	      posts: null,
	      comments: null,
	      loading: true,
      	  errored: false
	    }
	  },
	   mounted () {
		   axios
		  .get('https://my-json-server.typicode.com/davoo1995/menita_david/db')
		  .then(response => (
		  	
		  	this.posts = response.data.posts,
		  	this.comments = response.data.comments

		  	))
		  .catch(error => {
	        console.log(error)
	        this.errored = true
	      })
	      .finally(() => this.loading = false)
		},
		  methods: {
			deleteComment: function (index) {
				this.comments.splice(index, 1);
			    axios.delete('https://my-json-server.typicode.com/davoo1995/menita_david/comments/'+ index)
				    .then(function(response) {
	
				      alert("borrado exitoso")				      
				    }).catch(function(error) {
				      console.log(error)
				      alert("no se borro, contacta con soporte");
				    })
				    this.update();
		    	},
		    	addComment: function (id) {
		    		 var  params = {
					    body: this.coment,
					    postId: id
					  }
					   this.comments.push(params)
			    axios.post('https://my-json-server.typicode.com/davoo1995/menita_david/comments',params)
				    .then(function(response) {
				      alert("nuevo comentario");
				      this.coment= ' '
				    }).catch(function(error) {
				      console.log(error)
				      alert("no se agrego el comentario");
				    })
				    this.update();
		    	},
		    	 update() {
			      var parsed = JSON.stringify(this.comments);
			      localStorage.setItem('comments', parsed);
			    }
		  }

	})
</script>
</html>
