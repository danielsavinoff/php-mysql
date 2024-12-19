<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../assets/css/styles.css" />
  <title>Document</title>
</head>
<body>
  <? include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.php' ?>
  <div class="table-box">
    <table>
      <thead>
        <tr id="table-columns" />
      </thead>
      <tbody id="table-body" />
    </table>  
  </div>
  <p id="table-count" />
  <script>
    const columns = <?= json_encode($product->getAllColumns()->fetchAll()) ?>
    
    let total = <?= json_encode($product->getCount()->fetchColumn()) ?>

    let data = <?= json_encode($product->getAll(10)->fetchAll(PDO::FETCH_NUM)) ?>

    const tableBody = document.querySelector("#table-body")
    const hideButtons = document.querySelectorAll(".btn-hide-row")
    const tableCount = document.querySelector("#table-count")
    const tableColumns = document.querySelector("#table-columns")

    const hideRow = (index) => {
      // TODO: Make an optimistic update
      data = data.filter((e, i) => {
        if (i !== index) 
          return true
        else {
          fetch(`/products/${e[0]}`, {
            method: "PATCH",
            body: JSON.stringify({
              IS_HIDDEN: true
            }),
            headers: {
              "Content-Type": "application/json" 
            }
          })
        }
      })

      updateTableCount()
      renderRows()
    }

    const changeAmount = (index, value) => {
      data[index][4] += value

      fetch(`/products/${data[index][0]}`, {
        method: "PATCH",
        body: JSON.stringify({
          PRODUCT_QUANTITY: data[index][4]
        }),
        headers: {
          "Content-Type": "application/json" 
        }
      })

      renderRows()
    }
    
    const updateTableCount = () => tableCount.textContent = `${data.length} out of ${total}`
    
    const renderRows = () => {
      tableBody.innerHTML = ""

      data.forEach((row, i) => {
        const rowElement = document.createElement("tr")

        row.forEach((cell, j) => {
          const cellElement = document.createElement("td")
          const spanElement = document.createElement("span")
          spanElement.textContent = cell
          cellElement.appendChild(spanElement)

          cellElement.classList.add(`value-${columns[j]["Field"]}`)

          rowElement.appendChild(cellElement)
        })

        const hideButtonCellElement = document.createElement("td")
        const hideButtonElement = document.createElement("button")
        
        hideButtonElement.innerText = "Hide"
        hideButtonElement.addEventListener("click", () => hideRow(i)) 
        
        hideButtonCellElement.appendChild(hideButtonElement)

        rowElement.appendChild(hideButtonCellElement)

        const amountCellElement = rowElement.querySelector(".value-PRODUCT_QUANTITY")
        const increaseButtonElement = document.createElement("button")
        const decreaseButtonElement = document.createElement("button")
        increaseButtonElement.innerText = "+"
        decreaseButtonElement.innerText = "-"
        increaseButtonElement.addEventListener('click', e => changeAmount(i, 1))
        decreaseButtonElement.addEventListener('click', e => changeAmount(i, -1))
        amountCellElement.appendChild(increaseButtonElement)
        amountCellElement.appendChild(decreaseButtonElement)


        tableBody.appendChild(rowElement)
      })
    }

    const renderColumns = () => {
      columns.forEach(column => {
        const theader = document.createElement('th')

        theader.textContent = column["Field"]

        tableColumns.appendChild(
          theader
        )
      })
    }

    renderColumns()
    updateTableCount()
    renderRows()
  </script>
</body>
</html>