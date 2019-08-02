@extends('layouts.app')

@section('content')
<div class="container">
    <user-playlists :user="{{ auth()->user()->id }}" inline-template>
        <div>
            <div v-if="message && message.text" :class="'bg-white text-center rounded shadow p-5 h4 mb-5 text-'+message.type">
                @{{ message.text }}
            </div>

            <div class="row mb-4" v-for="(playlist, index) in playlists">
                <div class="col-8">
                    <h2 class="font-weight-bold">@{{ playlist.name }}</h2>

                    <p class="mb-0" v-if="playlist.owner">Owner: @{{ playlist.owner.display_name ? playlist.owner.display_name : playlist.owner.id }}</p>
                    <p v-if="playlist.tracks">Tracks: @{{ playlist.tracks.total }}</p>
                </div>

                <div class="col-4">
                    <div class="bg-white shadow rounded overflow-hidden">
                        <ul class="list-group list-group-flush overflow-hidden">
                            <li class="list-group-item">Collaborative: @{{ playlist.collaborative }}</li>
                            <li class="list-group-item">Public: @{{ playlist.public }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </user-playlists>

    <div class="create-playlist" data-toggle="modal" data-target="#exampleModal">
        <button class="btn btn-primary btn-lg rounded-circle shadow">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <create-playlist :user="{{ auth()->user()->id }}" inline-template>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Playlist</h5>
                        <button type="button" class="btn btn-sm close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="playlistName">Name</label>
                            <input type="text" class="form-control" name="playlistName" id="playlistName" v-model="name" />
                        </div>

                        <div class="form-group">
                            <label for="playlistId">Playlist ID</label>
                            <input type="text" class="form-control" name="playlistId" id="playlistId" v-model="id" />
                            <small class="form-text">If you want to use a playlist you've already created, put the ID of it here.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Create Playlist</button>
                    </div>
                </div>
            </create-playlist>
        </div>
    </div>
</div>
@endsection
