const insert_soal = document.getElementById("insert_soal");
const soal_ujian = document.getElementById("soal-ujian");

const add_soal = () => {
  let number_soal = ++soal_ujian.children.length;
  const newRow = document.createElement("div");
  newRow.setAttribute("class", "row mt-3");

  const newCols = document.createElement("div");
  newCols.setAttribute("class", "col-lg-11 col-md-12 col-sm-12");
  newRow.appendChild(newCols);

  const newCard = document.createElement("div");
  newCard.setAttribute("class", "card mx-2");
  newCols.appendChild(newCard);

  const newCardBody = document.createElement("div");
  newCardBody.setAttribute("class", "card-body");
  newCard.appendChild(newCardBody);

  const newJudulSoal = document.createElement("h4");
  newJudulSoal.setAttribute("class", "d-inline-block mr-3");
  newJudulSoal.innerHTML = "Soal " + number_soal;
  newCardBody.appendChild(newJudulSoal);

  const newDivBobotSoal = document.createElement("div");
  newDivBobotSoal.setAttribute("class", "form-group mt-4");
  newCardBody.appendChild(newDivBobotSoal);

  const newLabelBobotSoal = document.createElement("label");
  newLabelBobotSoal.setAttribute("for", "bobot-" + number_soal);
  newLabelBobotSoal.innerHTML = "Bobot nilai";
  newDivBobotSoal.appendChild(newLabelBobotSoal);

  const newBobotSoal = document.createElement("input");
  newBobotSoal.setAttribute("class", "form-control border-dark w-25");
  newBobotSoal.setAttribute("type", "number");
  newBobotSoal.setAttribute("name", "bobot_nilai[]");
  newBobotSoal.setAttribute("id", "bobot-" + number_soal);
  newDivBobotSoal.appendChild(newBobotSoal);

  const newDivSoal = document.createElement("div");
  newDivSoal.setAttribute("class", "form-group");
  newCardBody.appendChild(newDivSoal);

  const newLabelSoal = document.createElement("label");
  newLabelSoal.setAttribute("for", "soal-" + number_soal);
  newLabelSoal.innerHTML = "Soal :";
  newDivSoal.appendChild(newLabelSoal);

  const newSoal = document.createElement("textarea");
  newSoal.setAttribute("class", "form-control border-dark");
  newSoal.setAttribute("name", "soal[]");
  newSoal.setAttribute("id", "soal-" + number_soal);
  newSoal.setAttribute("rows", "20");
  newDivSoal.appendChild(newSoal);

  const newDivJawaban = document.createElement("div");
  newDivJawaban.setAttribute("class", "form-group");
  newCardBody.appendChild(newDivJawaban);

  const newLabelJawaban = document.createElement("label");
  newLabelJawaban.setAttribute("for", "jawaban-" + number_soal);
  newLabelJawaban.innerHTML = "Jawaban :";
  newDivJawaban.appendChild(newLabelJawaban);

  const newJawaban = document.createElement("textarea");
  newJawaban.setAttribute("class", "form-control border-dark");
  newJawaban.setAttribute("name", "jawaban[]");
  newJawaban.setAttribute("id", "jawaban-" + number_soal);
  newJawaban.setAttribute("rows", "20");
  newDivJawaban.appendChild(newJawaban);

  soal_ujian.appendChild(newRow);
};

const remove_soal = () => {
  if (soal_ujian.children.length > 1) {
    soal_ujian.removeChild(soal_ujian.children[soal_ujian.children.length - 1]);
  }
};
