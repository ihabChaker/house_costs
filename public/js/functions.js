const statusesEnum = Object.freeze({
    SUCCESS: "success",
    ERROR: "error",
});

async function confirmAction() {
    const result = await Swal.fire({
        title: "هل انت متاكد؟",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "نعم",
    });

    return result.value == true;
}

function showMessage(title, text, type) {
    Swal.fire({
        title: title,
        text: text,
        // icon: type,
        showConfirmButton: true,
        timer: 1500,
    });
}
function refreshDatatable() {
    let myDatatable = $("#data-table").DataTable();
    myDatatable.ajax.reload();
}
async function sendDeleteRequest(url) {
    let isConfirmed = await confirmAction();

    if (!isConfirmed) return;

    axios
        .delete(url, {
            headers: {
                "X-CSRF-TOKEN": document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
        .then((response) => {
            showMessage("Success!", "تم الحذف بنجاح", statusesEnum.SUCCESS);
            refreshDatatable();
        })
        .catch((error) => {
            console.log(error.config);
            showMessage("Error!", "حدث خطأ", statusesEnum.ERROR);
        });
}
function formatNumber(input) {
    if (isNaN(parseInt(input.value.replace(/,/g, '')))) {
        input.value = 0
        return;
    }
    let value = parseInt(input.value.replace(/,/g, ''));
    let formattedValue = value.toLocaleString("en");
    input.value = formattedValue;
}

function parseFormattedNumber(str) {
    let value = parseInt(str.replace(/,/g, ''));
    return value
}