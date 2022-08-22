$(function () {
    const url = "http://localhost:1001/api/";
    const csrf = $("meta[name=csrf]").attr("content");

    function AxiosInstance() {
        const instance = axios.create({
            baseURL: url,
            timeout: 30000,
            headers: {
                // Authorization:
                //     "Bearer " + sessionStorage.getItem("token") ?? "",
                Accept: "application/json",
                "Content-Type": "application/json",
            },
        });

        return instance;
    }

    if ($("#department-table").length) {
        let departmentTable = $("#department-table").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            columns: [
                {
                    searchable: true,
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/department",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                },
                pages: 5,
            }),
        });
    }

    if ($("#jabatan-table").length) {
        let jabatanTable = $("#jabatan-table").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            columns: [
                {
                    searchable: true,
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/jabatan",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                },
                pages: 5,
            }),
        });
    }

    if ($("#grade-table").length) {
        let gradeTable = $("#grade-table").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            columns: [
                {
                    searchable: true,
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/grade",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                },
                pages: 5,
            }),
        });
    }

    if ($("#product-table").length) {
        let productTable = $("#product-table").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            columns: [
                {
                    searchable: true,
                    orderable: true,
                },
                {
                    searchable: true,
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/product",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                },
                pages: 5,
            }),
        });
    }

    if ($("#credit-scheme-table").length) {
        let creditSchemeTable = $("#credit-scheme-table").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            order: [0, "asc"],
            columns: [
                {
                    searchable: true,
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: false,
                },
                {
                    searchable: false,
                    orderable: false,
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/credit_scheme",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                },
                pages: 5,
            }),
        });
    }
});
