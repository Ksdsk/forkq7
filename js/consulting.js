let itTrans = 'it-transformation';
let itsmSoftProc = 'itsm-software-proc-design-dev';
let itsmDesMgmt = 'itsm-prog-design-mgmt';
let itProcEval = 'itsm-proc-eval';

function displayType(type1, type2, type3, type4) {
  document.querySelector(`[data-consulting-type=${type1}]`).classList.remove("d-none");
  document.querySelector(`[data-consulting-type=${type2}]`).classList.add("d-none");
  document.querySelector(`[data-consulting-type=${type3}]`).classList.add("d-none");
  document.querySelector(`[data-consulting-type=${type4}]`).classList.add("d-none");
}

document.getElementById(itTrans).addEventListener("click", ()=> displayType(itTrans, itProcEval, itsmDesMgmt, itsmSoftProc));

document.getElementById(itProcEval).addEventListener("click", ()=> displayType(itProcEval, itTrans, itsmDesMgmt, itsmSoftProc));

document.getElementById(itsmDesMgmt).addEventListener("click", ()=> displayType(itsmDesMgmt, itProcEval, itTrans, itsmSoftProc));

document.getElementById(itsmSoftProc).addEventListener("click", ()=> displayType(itsmSoftProc, itProcEval, itsmDesMgmt, itTrans));