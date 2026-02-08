# 💎 PHP USDT TRC20 Payment Gateway (No KYC)

![PHP](https://img.shields.io/badge/PHP-8.x-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple)
![Crypto](https://img.shields.io/badge/Crypto-USDT_TRC20-green)
![License](https://img.shields.io/badge/License-MIT-success)

A **lightweight, modern, and minimal crypto payment gateway** built with **pure PHP** to accept **USDT payments on the TRC20 network** without KYC.

This project is ideal for selling **digital products**, **templates**, **files**, or **online services** using a clean and professional crypto payment flow.

---

## ✨ Key Features

✅ No KYC required  
✅ USDT (TRC20) payments  
✅ Fully self-hosted (no third-party gateway)  
✅ Automatic order expiration (59 minutes)  
✅ Unique amount per order (prevents payment collision)  
✅ Multiple wallet support  
✅ QR code payment  
✅ Modern, minimal & responsive UI (Bootstrap 5)  
✅ Cancel payment option  
✅ Works on shared hosting (cPanel)  

---

## 🧠 How the System Works (Concept)

This gateway does **NOT** generate a wallet per user.  
Instead, it uses a **smart unique amount system**:

1. Each order gets a **slightly unique USDT amount**
2. Payments are matched by:
   - Wallet address
   - Exact amount
   - Time window
3. This allows:
   - Multiple users
   - Same wallet
   - No conflicts

✅ Safe  
✅ Simple  
✅ No blockchain interaction required on checkout page  

---

## 🔁 Payment Flow (Step by Step)

```text
User clicks Buy
      ↓
create_order.php
      ↓
Order created in database (unique amount)
      ↓
pay.php
(QR Code + Address + Timer)
      ↓
User sends USDT
      ↓
Auto verification (Cron / API)
      ↓
Success or Expired
