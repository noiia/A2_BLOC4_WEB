pagination = $("#pagination").pagination({
    maxVisible: 5,
    paginationClass: "container-pagination",
});

pagination.on("changePage", async function (event, page) {
    const element = $("#companies");
    console.log(page);
    //setLoading(element);
    //retrieve(element, $("#companyTile"), `/api/companies/${page}?${filters}`);
    //pagination.setCount(Math.ceil((await fetch(`/api/count/companies?${filters}`).then(response => response.json().then(data => data)))["count"] / 12));
});

pagination.changePage();