<form action="/mahasiswa/{{$mahasiswa->id}}" method="POST">

@csrf
@method('PUT')

<input type="text"
name="nim"
value="{{$mahasiswa->nim}}"><br><br>

<input type="text"
name="nama"
value="{{$mahasiswa->nama}}"><br><br>

<input type="text"
name="jurusan"
value="{{$mahasiswa->jurusan}}"><br><br>

<button type="submit">
Update
</button>

</form>