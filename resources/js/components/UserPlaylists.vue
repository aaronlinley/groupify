<script>
    export default {
    	props: ['user'],
    	data() {
    		return {
    			playlists: [],
                message: {}
            }
        },
        mounted() {
            this.getProfiles();
        },
        methods: {
    		getProfiles: function() {
				axios.get('api/playlists/'+this.user+'/get').then(response => {
					this.playlists = response.data.playlists.items;
					this.message = response.data.message;
				});
            }
        }
    }
</script>
