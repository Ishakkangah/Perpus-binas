<div class="" style="background:#9400D3; color:#fff"><center>Detail buku</center></div>
<dl class="dl-horizontal">
    <dt>Judul buku</dt>
    <dd><%= obj.book_name %></dd>
    <dt>Penulis</dt>
    <dd><%= obj.author %></dd>
    <dt>Kategori buku</dt>
    <dd><%= obj.category %></dd>
    <dt>Status tersedia</dt>
    <dd><%= obj.available_status %></dd>
    <dt>Tanggal edisi</dt>
    <dd><%= obj.updated_at %></dd>
</dl>

<%
    if(obj.hasOwnProperty('student')){
%>
<div class="" style="background:#9400D3; color:#fff"><center>Detail siswa</center></div>
<dl class="dl-horizontal">
    <dt>Student ID</dt>
    <dd><%= obj.student.student_id %></dd>
    <dt>Student Name</dt>
    <dd><%= obj.student.first_name %> <%= obj.student.last_name %></dd>
    <dt>Student Category</dt>
    <dd><%= obj.student.category %></dd>
    <dt>Roll Number</dt>
    <dd><%= obj.student.roll_num %></dd>
</dl>
<%
    }
%>
