@extends('layouts.app')

@section('content')
<div class="container">
    <user-profile :user="{{ auth()->user()->id }}" inline-template>
        <div>
            <div v-if="message && message.text" :class="'bg-white text-center rounded shadow p-5 h4 mb-5 text-'+message.type">
                @{{ message.text }}
            </div>

            <div class="form-group">
                <label for="userName">Name</label>
                <input type="text" class="form-control" name="userName" id="userName" v-model="name" />
            </div>

            <div class="form-group">
                <label for="spotifyUserId">Spotify User ID</label>
                <input type="text" class="form-control" name="spotifyUserId" id="spotifyUserId" v-model="spotifyUserID" disabled readonly />
            </div>

            <button class="btn btn-primary rounded-pill px-3 py-2" @click.prevent="saveProfile"><i class="fas fa-save mr-1"></i> Save</button>
        </div>
    </user-profile>
</div>
@endsection
