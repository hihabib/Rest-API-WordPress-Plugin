<?php
// if accessed directly
if (!defined("ABSPATH")) {
    exit;
}

add_shortcode("API_VOID_VIEWS", function () {
    ob_start();
    ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        #api-void > div {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 60px;
        }
        #api-void input {
            width: 100%;
            padding: 20px 10px;
        }
    </style>
    <form id="api-void" action="<?php the_permalink(); ?>">
        <div>
            <div>
                <input id="domainSearch" name="domainSearch" type="text" placeholder="Enter Your Domain">
            </div>
            <div>
                <input type="submit" value="Search">
            </div>
        </div>
    </form>
    <div id="tableContainer">

    </div>

    <script>
        /**
         * Create Table
         * @param title
         * @param data
         */
        function createTable(title, data) {
            const container = document.createElement('div');
            const heading = document.createElement('h2');
            heading.textContent = title;
            container.appendChild(heading);

            const table = document.createElement('table');
            Object.keys(data).forEach(key => {
                const row = document.createElement('tr');

                const cellKey = document.createElement('th');
                cellKey.textContent = key;
                row.appendChild(cellKey);

                const cellValue = document.createElement('td');
                cellValue.textContent = JSON.stringify(data[key], null, 2);
                row.appendChild(cellValue);

                table.appendChild(row);
            });

            container.appendChild(table);
            document.querySelector("#tableContainer #pleaseWait")?.remove();
            document.querySelector("#tableContainer").appendChild(container);
        }


        const form = document.querySelector('#api-void');
        form.addEventListener("submit", async e => {
            e.preventDefault();
            const domain = e.target.domainSearch.value;
            document.querySelector("#tableContainer").innerHTML = '<h3 id="pleaseWait">Please wait..</h3>'
            const res = await fetch("https://reportscammedfunds.com/wp-json/raw/v1/api-void?url=" + domain);
            const result = await res.json();
            createTable("Domain Age", result?.data?.report?.domain_age ?? {});
            createTable("DNS Records - NS", result?.data?.report?.dns_records?.ns?.records ?? {});
            createTable("DNS Records - MX", result?.data?.report?.dns_records?.mx?.records ?? {});
            createTable("Security Checks", result?.data?.report?.security_checks ?? {});
            createTable("Server Details", result?.data?.report?.server_details ?? {});
            createTable("URL Parts", result?.data?.report?.url_parts ?? {});
            createTable("Web Page", result?.data?.report?.web_page ?? {});
        });
    </script>
    <?php
    return ob_get_clean();
});