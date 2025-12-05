document.addEventListener("DOMContentLoaded", function () {
  if (window.jsonEditorInitialized) return;
  window.jsonEditorInitialized = true;

  document.querySelectorAll(".json-editor-element").forEach(function (element) {
    const inputId = element.dataset.inputId;
    const jsonData = element.dataset.json || "{}";

    function updateHiddenInput(editorInstance) {
      const newData = editorInstance.getDataString();
      document.getElementById(inputId).value = newData;
    }

    const editor = new JSONedtr(jsonData, "#" + element.id, {
      runFunctionOnUpdate: "updateHiddenInput",
      instantChange: true,
    });

    window.updateHiddenInput = function (editorInstance) {
      updateHiddenInput(editorInstance);
    };

    if (jsonData && jsonData !== "{}") {
      updateHiddenInput(editor);
    }
  });
});
