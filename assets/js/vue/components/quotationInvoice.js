const quotationInvoice = Vue.component("quotation-invoice", {
  template: `
        <div>
            <div class="row">
                <div class="col-xs-6">
                    <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                </div>
                <div class="col-xs-6 text-right">
                    <form v-on:submit.prevent="sendMail">                    
                        <input type="email" v-model="quotation.SaleMaster_customer_email" style="display: none">
                        <button type="submit"><i class="fa fa-envelope"></i> send Mail</button>
                    </form>
                </div>
            </div>
            
            <div id="invoiceContent">
                <div class="row">
                    <div  class="col-xs-12 text-center">
                        <div _h098asdh>
                            Proforma Invoice
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <strong>Customer Name:</strong> {{ quotation.Customer_Name }}<br>
                        <strong>Customer Address:</strong> {{ quotation.Customer_Address }}<br>
                        <strong>Customer Mobile:</strong> {{ quotation.Customer_Mobile }}<br>
                        <strong>Customer Email:</strong> {{ quotation.Customer_Email }}
                    </div>
                    <div class="col-xs-4 text-right">
                        <strong>Ref. Number:</strong> {{ quotation.Ref_Number }}<br>
                        <strong>Created by:</strong> {{ quotation.AddBy }}<br>
                        <strong>Invoice No.:</strong> {{ quotation.SaleMaster_InvoiceNo }}<br>
                        <strong>Date:</strong> {{ quotation.SaleMaster_SaleDate }} {{ moment(quotation.AddTime).format('h:mm a') }}<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div _d9283dsc></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table _a584de>
                            <thead>
                                <tr>
                                    <td>Sl.</td>
                                    <td>Product</td>
                                    <td>Model</td>
                                    <td>H.S. Code</td>
                                    <td>Qnty</td>
                                    <td>Unit</td>
                                    <td>Unit Price</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, sl) in cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td style="text-align: left;">{{ product.Product_Name }}</td>
                                    <td>{{ product.model_no }}</td>
                                    <td>{{ product.hs_code }}</td>
                                    <td>{{ product.SaleDetails_TotalQuantity }}</td>
                                    <td>{{ product.Unit_Name }}</td>
                                    <td>{{ quotation.currency_name }} {{ product.SaleDetails_Rate }}</td>
                                    <td align="right">{{ quotation.currency_name }} {{ product.SaleDetails_TotalAmount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-6">
                        <table _t92sadbc2>
                            <tr>
                                <td><strong>Sub Total:</strong></td>
                                <td style="text-align:right">{{ quotation.currency_name }} {{ quotation.SaleMaster_SubTotalAmount }}</td>
                            </tr>
                            <tr>
                                <td><strong>VAT {{ ((quotation.SaleMaster_TaxAmount * 100) / quotation.SaleMaster_SubTotalAmount) }}%</strong></td>
                                <td style="text-align:right">{{ quotation.currency_name }} {{ quotation.SaleMaster_TaxAmount }}</td>
                            </tr>
                            <tr>
                                <td><strong>Discount:</strong></td>
                                <td style="text-align:right">{{ quotation.currency_name }} {{ quotation.SaleMaster_TotalDiscountAmount }}</td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 1px solid #ccc"></td></tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td style="text-align:right">{{ quotation.currency_name }} {{ quotation.SaleMaster_TotalSaleAmount }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                            <strong><u>TERMS & CONDITIONS</u></strong>
                                                       
                            <div class="termscondition" v-html="quotation.terms_condition"></div>
                    </div>
                </div>
            </div>
        </div>
    `,
  props: ["quotation_id"],
  data() {
    return {
      quotation: {
        SaleMaster_InvoiceNo: null,
        SaleMaster_customer_name: null,
        SaleMaster_customer_mobile: null,
        SaleMaster_customer_address: null,
        SaleMaster_SaleDate: null,
        SaleMaster_TotalSaleAmount: null,
        SaleMaster_TotalDiscountAmount: null,
        SaleMaster_TaxAmount: null,
        SaleMaster_SubTotalAmount: null,
        AddBy: null,
      },
      cart: [],
      style: null,
      companyProfile: null,
      currentBranch: null,
    };
  },
  created() {
    this.setStyle();
    this.getQuotations();
    this.getCompanyProfile();
    this.getCurrentBranch();
  },
  methods: {
    getQuotations() {
      axios
        .post("/get_quotations", { quotationId: this.quotation_id })
        .then((res) => {
          this.quotation = res.data.quotations[0];
          this.cart = res.data.quotationDetails;
        });
    },
    getCompanyProfile() {
      axios.get("/get_company_profile").then((res) => {
        this.companyProfile = res.data;
      });
    },
    getCurrentBranch() {
      axios.get("/get_current_branch").then((res) => {
        this.currentBranch = res.data;
      });
    },
    sendMail() {
      axios
        .post("/send_quotation_mail", {
          email: this.quotation.SaleMaster_customer_email,
          quotation: this.quotation.SaleMaster_SlNo,
        })
        .then((res) => {
          let r = res.data;
          if (r.success) {
            alert(r.message);
          }
        });
    },
    setStyle() {
      this.style = document.createElement("style");
      this.style.innerHTML = `
                div[_h098asdh]{
                    background-color:#e0e0e0;
                    font-weight: bold;
                    font-size:15px;
                    margin-bottom:15px;
                    padding: 5px;
                }
                div[_d9283dsc]{
                    padding-bottom:25px;
                    border-bottom: 1px solid #ccc;
                    margin-bottom: 15px;
                }
                table[_a584de]{
                    width: 100%;
                    text-align:center;
                }
                table[_a584de] thead{
                    font-weight:bold;
                }
                table[_a584de] td{
                    padding: 3px;
                    border: 1px solid #ccc;
                }
                table[_t92sadbc2]{
                    width: 100%;
                }
                table[_t92sadbc2] td{
                    padding: 2px;
                }
                table[_terms] td{
                    white-space: pre-wrap;
                }
                .termscondition table{
                    width: 100% !important;
                    margin:0 !important;
                }
            `;
      document.head.appendChild(this.style);
    },
    async print() {
      let invoiceContent = document.querySelector("#invoiceContent").innerHTML;
      let printWindow = window.open(
        "",
        "PRINT",
        `width=${screen.width}, height=${screen.height}, left=0, top=0`
      );
      printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Quotation Invoice</title>
                    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                    <style>
                        body, table{
                            font-size: 13px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12"><img src="/uploads/branchwiseimage/${
                              this.currentBranch.Company_Logo_org
                            }" alt="Logo" style="height:120px;width:100%;" /></div>
                            <!--<div class="col-xs-10" style="padding-top:20px;">
                                <strong style="font-size:18px;">${
                                  this.companyProfile.Company_Name
                                }</strong><br>
                                ${this.companyProfile.Repot_Heading}
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                ${invoiceContent}
                            </div>
                        </div>
                    </div>
                    <div class="container" style="position:fixed;bottom:15px;width:100%;">
                        <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;padding-bottom:6px;">
                            <div class="col-xs-6">
                                ** THANK YOU FOR YOUR BUSINESS **
                            </div>
                            <div class="col-xs-6 text-right">
                                <span style="text-decoration:overline;">Authorized Signature</span>
                            </div>
                        </div>

                        <div class="row" style="font-size:12px;">
                            <div class="col-xs-6">
                                Print Date: ${moment().format(
                                  "DD-MM-YYYY h:mm a"
                                )}, Printed by: ${this.quotation.AddBy}
                            </div>
                            <div class="col-xs-6 text-right">
                                Developed by: Link-Up Technologoy, Contact no: 01911978897
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            `);
      let invoiceStyle = printWindow.document.createElement("style");
      invoiceStyle.innerHTML = this.style.innerHTML;
      printWindow.document.head.appendChild(invoiceStyle);
      printWindow.moveTo(0, 0);

      printWindow.focus();
      await new Promise((resolve) => setTimeout(resolve, 1000));
      printWindow.print();
      printWindow.close();
    },
  },
});
