<script>
    export default {
    	props: ['user'],
    	data() {
    		return {
                name: '',
				spotifyUserID: '',
                message: {}
            }
        },
        mounted() {
    		this.getProfile();
    		this.spotifyUserID = this.user.spotify_user_id;
        },
        methods: {
    		getProfile() {
    			axios.get('api/users/'+this.user+'/get').then(response => {
                	let user = response.data.user;
                	this.name = user.name;
                	this.spotifyUserID = user.spotifyUserId;
                });
            },
    		saveProfile() {
    			axios.post('api/users/'+this.user+'/update', {
    				'name': this.name
                }).then(response => {
                	this.message = response.data.message;
                	this.getProfile();
                });
            }
        }
    }
</script>
