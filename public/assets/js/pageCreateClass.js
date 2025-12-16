document.addEventListener('DOMContentLoaded', () => {

    const sectionCreate = document.querySelector('.create-class');
    const sectionParam = document.querySelector('.param-class');

    const btnParam = document.querySelector('#btnParam');
    const btnClass = document.querySelector('#btnClass');

    const tabClassCreate = sectionCreate.querySelector('.btnAll.btnClicked');
    const tabParamCreate = btnParam;

    const tabClassParam = btnClass;
    const tabParamParam = sectionParam.querySelector('.btnAll.btnClicked');

    btnParam.addEventListener('click', () => {
        sectionCreate.classList.add('d-none');
        sectionParam.classList.remove('d-none');

        tabClassCreate.classList.remove('btnClicked');
        tabClassCreate.classList.add('btnUnClicked');

        tabParamCreate.classList.remove('btnUnClicked');
        tabParamCreate.classList.add('btnClicked');
    });

    btnClass.addEventListener('click', () => {
        sectionParam.classList.add('d-none');
        sectionCreate.classList.remove('d-none');

        tabParamParam.classList.remove('btnClicked');
        tabParamParam.classList.add('btnUnClicked');

        tabClassParam.classList.remove('btnUnClicked');
        tabClassParam.classList.add('btnClicked');
    });

});
