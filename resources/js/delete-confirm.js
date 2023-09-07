console.log("Js Loaded");

const deleteForms = document.querySelectorAll(".delete-form");

deleteForms.forEach((form) => {
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const projectName = form.dataset.name;

        const hasConfirmed = confirm(
            `Do you really want to delete ${projectName}?`
        );

        if (hasConfirmed) form.submit();
    });
});
