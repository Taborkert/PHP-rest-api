require("dotenv").config();

const FtpDeploy = require("ftp-deploy");
const ftpDeploy = new FtpDeploy();

const config = {
  sftp: true,
  host: process.env.FTP_HOST,
  port: parseInt(process.env.FTP_PORT, 10),
  user: process.env.FTP_USER,
  password: process.env.FTP_PASS,
  localRoot: __dirname + "/api",
  remoteRoot: process.env.FTP_ROOT,
  include: ["*", "**/*,", ".htaccess"],
  exclude: [],
  // delete ALL existing files at destination before uploading, if true
  deleteRemote: true,
  // Passive mode is forced (EPSV command is not sent)
  forcePasv: true,
};

ftpDeploy
  .deploy(config)
  .then((res) => console.log("taborkert.hu API is deployed", res))
  .catch((err) => console.log(err));
