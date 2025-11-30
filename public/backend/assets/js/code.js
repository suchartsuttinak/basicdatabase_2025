$(function(){
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'ท่านแน่ใจ ?',
            text: "ลบข้อมูลนี้ใช่หรือไม่ ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                    'ลบสำเร็จ!',
                    'ข้อมูลถูกลบเรียบร้อยแล้ว',
                    'success'
                )
            }
        }) 
    });
});