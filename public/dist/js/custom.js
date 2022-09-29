$(function () {
    const url = "http://localhost:1001/api/";
    const csrf = $("meta[name=csrf]").attr("content");
    const company = $("meta[name=company]").attr("content");
    const user = $("meta[name=user]").attr("content");
    const startOfYear = moment().startOf("year");
    const endOfyear = moment().endOf("year");

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

    $("body").on("click", ".confirm", function (e) {
        const prompt = window.confirm(
            "Proses ini tidak dapat di kembalikan, lanjutkan ?"
        );

        if (prompt) {
            return;
        }

        e.preventDefault();
    });

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
                    param.company_id = company;
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
                    param.company_id = company;
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
                    param.company_id = company;
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
                    param.company_id = company;
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
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/credit_scheme",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                    param.company_id = company;
                },
                pages: 5,
            }),
        });
    }

    if ($("#rule-table").length) {
        let ruleTable = $("#rule-table").DataTable({
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
                    orderable: false,
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/rule",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                    param.company_id = company;
                },
                pages: 5,
            }),
        });
    }

    if ($("#rule-container").length) {
        let ruleItem = $(".rule-item");

        $("#rule-add").click(function () {
            $("#rule-container").append(ruleItem.clone());
        });

        $("body").on("click", ".rule-del", function () {
            if ($(".rule-item").length > 1) {
                $(this).closest(".rule-item").remove();
            }
        });
    }

    if ($("#barang-table").length) {
        let barangTable = $("#barang-table").DataTable({
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
                    searchable: true,
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
                // {
                //     searchable: false,
                //     orderable: false,
                // },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/barang",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                    param.company_id = company;
                },
                pages: 5,
            }),
        });
    }

    if ($("#employee-table").length) {
        let employeeTable = $("#employee-table").DataTable({
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
                    searchable: true,
                    orderable: true,
                },
                {
                    searchable: true,
                    orderable: false,
                },
                {
                    searchable: true,
                    orderable: false,
                },
                {
                    searchable: true,
                    orderable: false,
                },
                {
                    searchable: true,
                    orderable: true,
                },
                {
                    searchable: true,
                    orderable: true,
                },
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
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/employee",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                    param.company_id = company;
                },
                pages: 5,
            }),
        });
    }

    if ($("#submission-table").length) {
        let submissionTable = $("#submission-table").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            order: [5, "desc"],
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
                    orderable: true,
                },
                {
                    searchable: false,
                    orderable: false,
                },
            ],
            ajax: $.fn.dataTable.pipeline({
                url: url + "app/submission",
                method: "POST",
                data: function (param) {
                    param.csrf = csrf;
                    param.company_id = company;
                    param.user_id = user;
                },
                pages: 5,
            }),
        });
    }

    if ($("#picapprove-table").length) {
        let picApproveTable;

        function loadPicApproveTable(start_date, end_date) {
            picApproveTable = $("#picapprove-table").DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                order: [6, "desc"],
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
                        searchable: true,
                        orderable: true,
                    },
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
                        orderable: true,
                    },
                    {
                        searchable: false,
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
                    url: url + "app/picapprove",
                    method: "POST",
                    data: function (param) {
                        param.csrf = csrf;
                        param.company_id = company;
                        param.user_id = user;
                        param.start_date = start_date.format("DD-MM-YYYY");
                        param.end_date = end_date.format("DD-MM-YYYY");
                    },
                    pages: 5,
                }),
            });
        }

        $('input[name="daterange"]').daterangepicker(
            {
                showDropdowns: true,
                alwaysShowCalendars: true,
                startDate: startOfYear,
                endDate: endOfyear,
                locale: {
                    format: "DD/MM/YYYY",
                },
                ranges: {
                    "Hari ini": [moment(), moment()],
                    "Bulan ini": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Tahun ini": [
                        moment().startOf("year"),
                        moment().endOf("year"),
                    ],
                },
            },
            function (start, end) {
                $('input[name="start_date_list_pengajuan"]').val(start);
                $('input[name="end_date_list_pengajuan"]').val(end);

                picApproveTable.destroy();

                loadPicApproveTable(start, end);
            }
        );

        loadPicApproveTable(startOfYear, endOfyear);
    }
});
